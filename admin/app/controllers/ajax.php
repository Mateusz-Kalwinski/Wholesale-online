<?php
ini_set('display_errors', 1);
class Ajax extends Controller
{
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Walidacja------Walidacja------Walidacja------Walidacja------Walidacja------Walidacja------Walidacja--//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function CheckNIP($str) {
        $str = preg_replace('/[^0-9]+/', '', $str);
        if (strlen($str) !== 10) {
            echo 'NIP jest nieprawidłowy';
            die;
        }
        $arrSteps = array(6, 5, 7, 2, 3, 4, 5, 6, 7);
        $intSum = 0;
        for ($i = 0; $i < 9; $i++) {
            $intSum += $arrSteps[$i] * $str[$i];
        }
        $int = $intSum % 11;
        $intControlNr = $int === 10 ? 0 : $int;
        if ($intControlNr == $str[9]) {
            $nip = $str;
            return $nip;
        }
        echo 'NIP jest nieprawidłowy';
        die;
    }
    public function checkPhone($phone){
        if(!preg_match('/^(?:\(?\+?48)?(?:[-\.\(\)\s]*(\d)){9}\)?$/', $phone) ) {
            echo 'Numer telefonu jest niepoprawny';
            die;
        } else {
            return $phone;
        }
    }
    public function checkMail($mail){
        if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            echo 'mail jest nieprawidłowy';
            die;
        }else{
            return $mail;
        }
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Klienci------Klienci------Klienci------Klienci------Klienci------Klienci------Klienci------Klienci---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function searchClient(){
        $searchClient = $this->model('clients')->searchClient();
        echo json_encode($searchClient);
    }
    public function addClient(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['username']) && isset($_POST['discount']) && !empty($_POST['place']) && !empty($_POST['code']) &&
                !empty($_POST['address']) && !empty($_POST['nip']) && !empty($_POST['mail']) && !empty($_POST['phone']) && isset($_POST['status'])) {

                $username = $_POST['username'];
                $discount = $_POST['discount'];
                $place = $_POST['place'];
                $code = $_POST['code'];
                $address = $_POST['address'];
                $nip = $this->CheckNIP($_POST['nip']);
                $phone = $this->checkPhone($_POST['phone']);
                $mail = $this->checkMail($_POST['mail']);
                $status = $_POST ['status'];
                $this->model('clients')->addClient($username, $discount, $place, $code, $address, $nip, $mail, $phone, $status);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function deleteClient(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if(!empty($_POST['id'])) {
                $id = $_POST['id'];

                $deleteClient = $this->model('clients')->deleteClient($id);
                echo json_encode($deleteClient);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function editClient(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['username']) && isset($_POST['discount']) && !empty($_POST['place']) && !empty($_POST['code']) &&
               !empty($_POST['address']) && !empty($_POST['mail']) && !empty($_POST['phone']) && !empty($_POST['id']) && isset($_POST['status'])){

                $id = $_POST['id'];
                $username = $_POST['username'];
                $discount = $_POST['discount'];
                $place = $_POST['place'];
                $code = $_POST['code'];
                $address = $_POST['address'];
                $phone = $this->checkPhone($_POST['phone']);
                $mail = $this->checkMail($_POST['mail']);
                $status = $_POST['status'];

                $this->model('clients')->editClient($id , $username, $discount, $place, $code, $address, $mail, $phone, $status);
                echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function banClient(){
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['status']) && !empty($_POST['id'])){

                $status = $_POST['status'];
                $id = $_POST['id'];

                $this->model('clients')->banClient($status, $id);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }
        }else{
            echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
        }
    }
    public function listClients(){
        $listClients = $this->model('clients')->listClients();
        echo json_encode($listClients);
    }
    public function sumOrders($userID){
        $sumOrders = $this->model('clients')->sumOrders($userID);
        echo json_encode($sumOrders);
    }

    public function addressesOfClient()
    {ini_set('display_errors',1);
        if($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['id'])){

                $id = $_POST['id'];

                echo json_encode($this->model('clients')->addressesOfClient($id));
            }
        }


    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Produkty------Produkty------Produkty------Produkty------Produkty------Produkty------Produkty------Produkty---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function searchProduct(){
        $searchProduct = $this->model('products')->searchProduct();
        echo json_encode($searchProduct);
    }
    public function addProduct(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['name']) && !empty($_POST['description']) && isset($_POST['price']) &&
                isset($_POST['discount']) && isset($_POST['quanityInStock']) && isset($_POST['reservation']) && !empty($_POST['id_parent']) &&
                isset($_POST['news']) && isset($_POST['status']) && !empty($_POST['unit']) && !empty($_POST['product_code'])){

                $name = $_POST['name'];

                $description = $_POST['description'];
                $price =$_POST['price'];
                $discount = $_POST['discount'];
                $quanityInStock = $_POST['quanityInStock'];
                $reservation = $_POST['reservation'];
                $id_parent = $_POST['id_parent'];
                $news = $_POST['news'];
                $status = $_POST['status'];
                $unit = $_POST['unit'];
                $product_code = $_POST['product_code'];

                $this->model('products')->addProduct($name, $description, $price, $discount, $quanityInStock,
                                                                          $reservation, $id_parent, $news, $status, $unit, $product_code);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else {
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function deleteProduct(){
        if($_SERVER['REQUEST_METHOD'] ==='POST'){
            if(!empty($_POST['id'])){

                $id = $_POST['id'];

                $deleteProducts = $this->model('products')->deleteProduct($id);
                echo json_encode($deleteProducts);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function editProduct(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['id']) && !empty($_POST['name']) && !empty($_POST['description']) && isset($_POST['price']) &&
               isset($_POST['discount']) && isset($_POST['quanityInStock']) && isset($_POST['reservation']) && !empty($_POST['id_parent']) &&
               isset($_POST['news']) && isset($_POST['status']) && !empty($_POST['unit']) && !empty($_POST['product_code'])){

                $id = $_POST['id'];
                $name = $_POST['name'];
                $description = $_POST['description'];
                $price =$_POST['price'];
                $discount = $_POST['discount'];
                $quanityInStock = $_POST['quanityInStock'];
                $reservation = $_POST['reservation'];
                $id_parent = $_POST['id_parent'];
                $news = $_POST['news'];
                $status = $_POST['status'];
                $unit = $_POST['unit'];
                $product_code = $_POST['product_code'];

                $this->model('products')->editProduct($id, $name,  $description, $price, $discount, $quanityInStock,
                                                                            $reservation, $id_parent, $news, $status, $unit, $product_code);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function addToNewsProduct(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['id']) && isset($_POST['news'])){

                $id = $_POST['id'];
                $news = $_POST['news'];

                $this->model('products')->addTonewsProduct($id, $news);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function addDiscountProduct(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['id']) && isset($_POST['discount'])){

                $id = $_POST['id'];
                $discount = $_POST['discount'];

                $this->model('products')->addDiscountProduct($id, $discount);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function changeStatus(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && $_POST['status']){
                $id = $_POST['id'];
                $status = $_POST['status'];
                $this->model('products')->changeStatus($id, $status);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function listProducts($limit=false){
        $listProducts = $this->model('products')->listProducts($limit);
        echo json_encode($listProducts);

    }

    public function addPhotoForProduct(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            print_r($_FILES);
            if(isset($_POST['id'])){
                $idProduct = $_POST['id'];
                $sort = 0;
                if (isset($_FILES['image'])){

                    $this->model('products')->addPhotoForProduct($idProduct, $_FILES['image'], $sort);
                   echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
                }else{
                     echo json_encode(['state'=>'error','text'=>'Błędna lokalizacja pliku']);
                }
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function setMainPhoto(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && isset($_POST['idProduct'])){
                $id = $_POST['id'];
                $idProduct = $_POST['idProduct'];

                $this->model('products')->setMainPhoto($id, $idProduct);
                echo json_encode(['state'=>'success', 'text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error', 'text'=>'Wszytskie pola powinny być usupełnione']);
            }
        }
    }
    public function deletePhoto(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['id'])){
               $id = $_POST['id'];
               $this->model('products')->deletePhoto($id);
               echo json_encode(['state' =>'success', 'text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error', 'text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    
    public function listProductPhotos()
    {
        if($_SERVER['REQUEST_METHOD']==='POST')
        {
            if(isset($_POST['id']))
            {
                $id=$_POST['id'];
                
                echo json_encode($this->model('products')->listPhotos($id));
            }
        }
    }
    
    public function setProductPhotosOrder()
    {
        if($_SERVER['REQUEST_METHOD']==='POST')
        {
            if( isset($_POST['photos']))
            {
                $photos= json_decode($_POST['photos'],true);
                $this->model('products')->sortPhoto($photos);
                
            }
        }
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Config------Config------Config------Config------Config------Config------Config------Config------Config//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function editConfig(){
        if($_SERVER['REQUEST_METHOD']==='POST'){
            if(!empty($_POST['id']) && !empty($_POST['val'])){

                $id = $_POST['id'];
                $value = $_POST['val'];
                if(isset($_FILES['image']))
                {
                   $fileType=explode('/',$_FILES['image']['type'])[1];
                   $fileData= file_get_contents($_FILES['image']['tmp_name']);
                   $value='data:image/' . $fileType . ';base64,' . base64_encode($fileData);

                }
                $this->model('config')->editConfig($id, $value);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);

            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Info------Info------Info------Info------Info------Info------Info------Info------Info---Info---Info---Info//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function infoAboutLicense(){
        $infoAboutLicense = $this->model('information')->infoLicense();
        echo json_encode($infoAboutLicense);
    }

    public function InfoAboutDetail(){
        $infoAboutDetail = $this->model('information')->infoDetails();
        echo json_encode($infoAboutDetail);
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---News------News------News------News------News------News------News------News------News---News---News---News//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function addNews(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['status'])){

                $title = $_POST['title'];
                $content = $_POST['content'];
                $status = $_POST['status'];

                $this->model('news')->addNews($title, $content, $status);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function deleteNews(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['id'])){

                $id = $_POST['id'];

                $deleteNews = $this->model('news')->deleteNews($id);
                echo json_encode($deleteNews);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function editNews(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['id']) && !empty($_POST['title']) && !empty($_POST['content']) && !empty($_POST['status'])){
                $title = $_POST['title'];
                $content = $_POST['content'];
                $status = $_POST['status'];
                $id=$_POST['id'];
                $date = $_POST['date'];

                $this->model('news')->editNews($id,$title, $content, $status, $date);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }

    public function changeNewsStatus(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['id']) && !empty($_POST['status'])){
                $status = $_POST['status'];
                $id=$_POST['id'];

                $this->model('news')->changeNewsStatus($id, $status);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
               echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Zamówienia------Zamówienia------Zamówienia------Zamówienia------Zamówienia------Zamówienia------Zamówienia---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function deleteOrder()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!empty($_POST['id'])) {

                $id = $_POST['id'];
                $deleteOrder = $this->model('orders')->deleteOrder($id);
                echo json_encode($deleteOrder);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            } else {
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function statusOrder(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['id']) && isset($_POST['status'])){

                $id = $_POST['id'];
                $status = $_POST['status'];

                $this->model('orders')->statusOrder($status, $id);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function paidOrder(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && isset($_POST['status'])){
                $id = $_POST['id'];
                $status = $_POST['status'];

                $this->model('orders')->paidOrder($status, $id);
                echo json_encode(['state'=>'success', 'text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error', 'text'=>'Wszystkie pola powinny być wypełnione']);
            }
        }
    }
    public function listOrder($id){
        $listOrder = $this->model('orders')->listOrder($id);
        echo json_encode($listOrder);
    }
    public function editOrder(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && !empty($_POST['name']) && !empty($_POST['place']) && !empty($_POST['address']) &&
               !empty($_POST['code']) && isset($_POST['state'])&&  isset($_POST['paid']) && !empty($_POST['payment'])){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $place = $_POST['place'];
                $address = $_POST['address'];
                $code = $_POST['code'];
                $comment = $_POST['comment'];
                $stan = $_POST['state'];
                $stanPaid = $_POST['paid'];
                $shipment=$_POST['payment'];
                
                if($_POST['send']==1)
                {
                    $this->orderCorrection($id);
                }

                $this->model('orders')->editOrder($id, $name, $place, $address, $code, $comment, $stan, $stanPaid, $shipment);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function listStatus(){
        $listStatus = $this->model('orders')->listStatus();
        echo json_encode($listStatus);
    }
    public function listShipment(){
        $listShipment = $this->model('orders')->listShipment();
        echo json_encode($listShipment);
    }
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Dostawa------Dostawa------Dostawa------Dostawa------Dostawa------Dostawa------Dostawa------Dostawa------Dostawa---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    public function addShipment(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (!empty($_POST['name']) && isset($_POST['status'])){
                $name = $_POST['name'];
                $comment = $_POST['comment'];
                $status = $_POST['status'];
                $this->model('payment')->addShipment($name, $comment, $status);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
               echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function editShipment(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if (isset($_POST['id']) && !empty($_POST['name']) && isset($_POST['status'])){
                $id = $_POST['id'];
                $name = $_POST['name'];
                $comment = $_POST['comment'];
                $status = $_POST['status'];
                $this->model('payment')->addShipment($id, $name, $comment, $status);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
               echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function listDelivery(){
        $listDelivery = $this->model('payment')->listDelivery();
        echo json_encode($listDelivery);
    }
    public function addPayment(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(!empty($_POST['method_payment']) && isset($_POST['delivery_price_1']) && isset($_POST['delivery_price_2']) &&
               isset($_POST['free_delivery']) && isset($_POST['sort']) && isset($_POST['stan']) && isset($_POST['id_parent'])){
                $methodPayment = $_POST['method_payment'];
                $deliveryPrice1 =$_POST['delivery_price_1'];
                $deliveryPrice2 = $_POST['delivery_price_2'];
                $freeDelivery = $_POST['free_delivery'];
                $sort = $_POST['sort'];
                $stan = $_POST['stan'];
                $id_parent = $_POST['id_parent'];

                return $this->model('payment')->addPayment($methodPayment, $deliveryPrice1, $deliveryPrice2, $freeDelivery, $sort, $stan, $id_parent);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function editPayment(){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && !empty($_POST['method_payment']) && isset($_POST['delivery_price_1']) && isset($_POST['delivery_price_2']) &&
                isset($_POST['free_delivery']) && isset($_POST['sort']) && isset($_POST['stan']) && isset($_POST['id_parent'])){
                $id = $_POST['id'];
                $methodPayment = $_POST['method_payment'];
                $deliveryPrice1 =$_POST['delivery_price_1'];
                $deliveryPrice2 = $_POST['delivery_price_2'];
                $freeDelivery = $_POST['free_delivery'];
                $sort = $_POST['sort'];
                $stan = $_POST['stan'];
                $id_parent = $_POST['id_parent'];

                return $this->model('payment')->editPayment($id, $methodPayment, $deliveryPrice1, $deliveryPrice2, $freeDelivery, $sort, $stan, $id_parent);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function listPayment(){
        $listPayment = $this->model('payment')->listPayment();
        echo json_encode($listPayment);
    }
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Edycja Produktu------Edycja Produktu------Edycja Produktu------Edycja Produktu------Edycja Produktu---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function getProductFromOrder($id){
        $this->model('orders')->getProductFromOrder($id);
    }

    public function deleteProductFromOrder(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && isset($_POST['id_product'])){

                $id = $_POST['id'];
                $id_product = $_POST['id_product'];

                $deleteProductFromOrder = $this->model('orders')->deleteProductFromOrder($id, $id_product);
                echo json_encode($deleteProductFromOrder);
            }
        }
    }
    public function addProductToOrder($id, $id_product, $quantity){
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id']) && isset($_POST['id_product']) && isset($_POST['quantity'])) {
                $id = $_POST['id'];
                $id_product = $_POST['id_product'];
                $quantity = $_POST['quantity'];
                $this->model('orders')->addProductFromOrder($id, $id_product, $quantity);
            }
        }
    }
    public function changeQuanity(){
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            if(isset($_POST['id']) && isset($_POST['id_product']) && isset($_POST['quanity'])){
                $id = $_POST['id'];
                $id_product = $_POST['id_product'];
                $quantity = $_POST['quanity'];
                $this->model('orders')->changeQuanity($id,$id_product, $quantity);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }
            else
            {
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Kategorie------Kategorie------Kategorie------Kategorie------Kategorie------Kategorie------Kategorie---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function addCategory(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['categoryName'])&&isset($_POST['idParent'])){
                $name = $_POST['categoryName'];
                $idParent = $_POST['idParent'];
                $this->model('categories')->addCategory($name, $idParent);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function deleteCategory(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['id'])){
                $id = $_POST['id'];
                $deleteCategory = $this->model('categories')->deleteCategory($id);
                echo json_encode($deleteCategory);
               echo json_encode(['state'=>'success','text'=>'Operacja zakończona sukcesem']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }
    public function editCategory(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['categoryName']) and isset($_POST['state']) and isset($_POST['id'] )and isset($_POST['idParent'])){
                $name = $_POST['categoryName'];
                $id=$_POST['id'];
                $state=$_POST['state'];
                $idParent=$_POST['idParent'];
                $this->model('categories')->editCategory($name,$id,$state,$idParent);
              echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }else{
                echo json_encode(['state'=>'error','text'=>'Wszystkie pola powinny być uzupełnione']);
            }
        }
    }

    public function listCategory(){
        $listCategory = $this->model('categories')->listCategory();
        echo json_encode($listCategory);
    }
    
    public function reorderCategories()
    {
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            if(isset($_POST['categoryList'])){
                $categoriesList=$_POST['categoryList'];
                
                $this->model('categories')->reorderCategories($categoriesList);
                echo json_encode(['state'=>'error','text'=>'Zmieniono kolejność kategorii']);
            }
        }
    }

    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//
    //---Mail------Mail------Mail------Mail------Mail------Mail------Mail------Mail------Mail------Mail------Mail---//
    //--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//--//

    public function orderCorrection($id_order){
        $this->model('orders')->orderCorrection($id_order);
    }
}
