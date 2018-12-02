<?php

ini_set('display_errors',1);
session_name('user');
session_save_path(realpath(dirname($_SERVER['DOCUMENT_ROOT']) . '/../sessions'));
ini_set('session.gc_probability', 1);
ini_set('session.gc_divisor', 100);
ini_set('session.gc_maxlifetime', 259200);
session_set_cookie_params(259200);
session_start();

require_once dirname(dirname(dirname(__FILE__))).'/app/models/mail.php';
require_once dirname(dirname(dirname(__FILE__))).'/app/models/pdfModel.php';
require_once dirname(dirname(dirname(__FILE__))).'/app/models/notifications.php';
require_once dirname(dirname(__FILE__)).'/config.php';
$responseMessage='';

if($_SERVER['REQUEST_METHOD'] === "POST") {
    //za[isac name w bazie danych. Name idzie postem
    if (!empty($_POST['delivery']) and !empty($_POST['place']) and !empty($_POST['postal']) and !empty($_POST['name']) and !empty($_POST['address']) and !empty($_POST['phone'])) {

        $delivery = $_POST['delivery'];

        /*Poniższe wartości są ok, dostosowałem nazwy*/
        $place = $_POST['place'];
        $code = $_POST['postal'];
        $name = $_POST['name'];
        $address = $_POST['address'];
        $phone = $_POST['phone'];
        $comment = $_POST['comment'];

        $id = $_SESSION['id'];

        $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_DBNAME . ";charset=utf8", DB_USER, DB_PASSWORD);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $query1 = "SELECT `cart`.*,`products`.*, `units`.`unit`, users.discount as user_discount, users.nip, products.id as product_id
                   FROM cart
                   INNER JOIN products ON cart.id_produkt= products.id
                   INNER JOIN users ON cart.id_user = users.id
                   INNER JOIN `units` ON `units`.`id`=`products`.`unit`
                   WHERE cart.id_user = '$id'";
        $stmt1 = $conn->prepare($query1);
        $error = $stmt1->execute();
        $result3 = $stmt1->fetchAll(PDO::FETCH_ASSOC);



        if (!empty($result3)) {
            $nip = $result3[0]['nip'];
            $case = $result3[0]['quanityInStock'] - $result3[0]['reservation'];
            $cartQuanity = 0;
            $cartValue = 0;

            $changedProductsList='';
            $changedProductsCounter=0;
            foreach ($result3 as $cartData) {
                if ($case < $cartData['ilosc']) {
                    $result3[0]['ilosc'] = $case;
                    $subtraction = $cartData['quanityInStock'] - $cartData['reservation'];
                    $changedProductsList.=$cartData['name'] . ' z ' . $cartData['ilosc'] .' '.$cartData['unit']. ' zmieniono na ' . $subtraction .' '.$cartData['unit'];
                    $changedProductsList.='<br>';
                    $changedProductsCounter++;
                    $cartData['ilosc'] = $case;
                }
                $messagesFromDatabaseSq ='SELECT * FROM `notifications`';

                $notificationsModel=new Notifications;
                $notifications=$notificationsModel->notifications();
                if(!empty($changedProductsList))
                {
                  if($changedProductsCounter===sizeof($result3))
                  {
                    $responseMessage.=$notifications[22]['text'];
                    echo $responseMessage;
                    exit;
                  }


                  $responseMessage.=$notifications[23]['text'];
                  $responseMessage.=$changedProductsList;
                }


                $changeQuanityInStock = $cartData['quanityInStock'] - $cartData['ilosc'];
                $productId = $cartData['product_id'];

                $sqlChangeQuanityInStock = "UPDATE products
                                            SET quanityInStock = $changeQuanityInStock
                                            WHERE id = $productId";
                $stmtChangeQuanityInStock = $conn->prepare($sqlChangeQuanityInStock);
                $execChangeQuanityInStock = $stmtChangeQuanityInStock->execute();

                $cartQuanity += $cartData['ilosc'];
                $cartValue += $cartData['ilosc'] * ceil($cartData['price'] * ((100 - $cartData['user_discount']) / 100) * ((100 - $cartData['discount']) / 100) * 100) / 100;
            }
            $product = serialize($result3);
            $productPrice = $cartValue;
            $query2 = "SELECT payment.method_payment,payment.delivery_price_1, transport.name FROM payment
                   INNER JOIN transport ON payment.id_parent = transport.id
                   WHERE payment.id = '$delivery'";

            $stmt2 = $conn->prepare($query2);
            $error2 = $stmt2->execute();
            $result2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

            $transport = $result2[0]['name'];
            $methodPayent = $result2[0]['method_payment'];
            $deliveryPrice = $result2[0]['delivery_price_1'];


            $query5 = "SELECT value FROM config WHERE id = '10'";
            $stmt5 = $conn->prepare($query5);
            $error5 = $stmt5->execute();
            $result5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
            $minPrice = $result5[0]['value'];


            //rondomowy string
            do {
                $orderNumber = "";
                $characters = array_merge(range('0', '9'));
                $max = count($characters) - 1;
                for ($i = 0; $i < 7; $i++) {
                    $rand = mt_rand(0, $max);
                    $orderNumber .= $characters[$rand];

                }

                $orderNumber = $nip . '/' . $orderNumber;
                $date = date("Y-m-d H:i:s");
                $query1 = "SELECT order_number FROM orders_history WHERE order_number = '$orderNumber'";
                $stmt1 = $conn->prepare($query1);
                $error1 = $stmt1->execute();
                $result1 = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                if (empty($result1)) {
                    if ($productPrice > $minPrice) {
                        $deliveryPrice = 0;
                    }

                    $shipment = "$transport - $methodPayent + $deliveryPrice zł";
                    $productPrice = $cartValue + $deliveryPrice;

                    //jesli nie ma takiego numeru wykonaj insert
                    $query2 = "INSERT INTO orders_history (name, order_number, order_date, pay, shipment, order_status, product, place, code, address, phone, comment, id_user) VALUES
                              ('$name', '$orderNumber', '$date', '$productPrice', '$shipment', '0', '$product', '$place', '$code', '$address', '$phone', '$comment', '$id')";
                    $stmt2 = $conn->prepare($query2);
                    $error2 = $stmt2->execute();

                    $delete = "DELETE FROM cart WHERE id_user = '$id'";
                    $deleteStmt = $conn->prepare($delete);
                    $deleteError = $deleteStmt->execute();

                }
                //DO while
            } while (!empty($result1));
        }
        $orderNumberSql = "SELECT order_number, id FROM orders_history WHERE id_user = '$id' ORDER BY order_date DESC LIMIT 1";
        $orderNumberStml = $conn->prepare($orderNumberSql);
        $orderNumberErrot = $orderNumberStml->execute();
        $orderNumberResult = $orderNumberStml->fetch();

        $Number = $orderNumberResult['order_number'];
        $orderId = $orderNumberResult['id'];

        $query4 = "SELECT mail FROM users WHERE id = '$id'";
        $stmt4 = $conn->prepare($query4);
        $error4 = $stmt4->execute();
        $result4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
        if (!empty($result4)) {

            $explodeNumber = explode('/', $Number);
            $savePFD = 'zamowienie-' . $explodeNumber[1] . '.pdf';

            $pdf = new pdfModel();
            $pdf->generatePDF($explodeNumber[1], $savePFD);

            $recipient = $result4[0]['mail'];

            $mail = new Mail();
            $mail->valueMail(5, $recipient, $Number, $savePFD);
            $responseMessage='1'.$notifications[24]['text'].'<br>'.$responseMessage;
        }
    }
    else
    {
      $responseMessage=$notifications[25]['text'];
    }
    echo $responseMessage;
}
