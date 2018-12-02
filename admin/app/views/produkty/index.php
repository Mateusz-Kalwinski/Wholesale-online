<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
    
    <main class="content">
        <div class="main-container">
           <div class="main-content with-table">
             <div class="content-title">
                <?=Svg::create('kategoria')?>
                <div class="content-title-text">
                    <h4><?=$data['title']?></h4>
                    <p>Lista produktów</p>
                </div>
             </div>
                 <div class="table-panel">
                     <input class="input-custom search-product" type="text" placeholder="wyszukaj">
                    <button class="btn addProduct">dodaj produkt</button>
                 </div>
                 <table class="table table-clients">
                    <tr>
                        <th style="width:50px;">Edycja</th>
                        <th style="width:50px;">Galeria</th>
                        <th>Nazwa</th>
                        <th>Cena</th>
                        <th>Nowość</th>
                        <th>Rabat</th>
                        <th>Dostępny</th>
                        <th>Usuń</th>
                    </tr>
                    <?php
                    foreach($data['products'] as $product)
                    {
                        $onChecked=$product['status']==='1'?' checked ':'';
                        $offChecked=$product['status']==='2'?' checked ':'';
                        echo'
                        <tr data-id="'.$product['id'].'"
                            data-description="'.$product['description'].'"
                            data-quanity="'.$product['quanityInStock'].'"
                            data-category="'.$product['id_parent'].'"
                            data-reservation="'.$product['reservation'].'"
                            data-unit="'.$product['unit'].'"
                            data-product_code="'.$product['kod_produktu'].'"
                            data-price="'.$product['price'].'"
                            data-state="'.$product['status'].'"
                            data-discount="'.$product['discount'].'"
                            data-news="'.$product['news'].'"
                            data-name="'.$product['name'].'"
                        >
                                     
                        <td style="width:50px;" class="editProduct">'.Svg::create('edit').'</td>
                        <td style="width:50px;" class="editGallery">'.Svg::create('photos').'</td>
                        <td class="name">'.$product['name'].'<p class="product-number">'.$product['kod_produktu'].'</p></td>
                        <td class="price">'.$product['price'].' zł</td>
                        <td class="new">';
                        
                            if($product['news']==='1')
                            {
                                echo'<span class="label-yes">tak</span>';
                                echo'<form class="ajax" method="post" action="/admin/ajax/addToNewsProduct">';
                                    echo'<input type="hidden" name="id" value="'.$product['id'].'">';
                                    echo'<input type="hidden" name="news" value="0">';
                                    echo'<button type="submit" class="btn-text">usuń z nowości</button>';
                                echo'</form>';
                            }
                            else
                            {
                                echo'<span class="label-no">nie</span>';
                                echo'<form class="ajax" method="post" action="/admin/ajax/addToNewsProduct">';
                                    echo'<input type="hidden" name="id" value="'.$product['id'].'">';
                                    echo'<input type="hidden" name="news" value="1">';
                                    echo'<button type="submit" class="btn-text">dodaj do nowości</button>';
                                echo'</form>';
                            }
                        
                        echo'</td>';
                        
                        echo'<td class="discount">';
                        
                            if($product['discount']!=='0')
                            {
                                echo'<span class="label-yes">tak</span>';
                                echo'<form class="ajax" method="post" action="/admin/ajax/addDiscountProduct">';
                                    echo'<input type="hidden" name="id" value="'.$product['id'].'">';
                                    echo'<input type="hidden" name="discount" value="0">';
                                    echo'<button type="submit" class="btn-text">usuń z promocji</button>';
                                echo'</form>';
                            }
                            else
                            {
                                echo'<span class="label-no">nie</span><br>';
                                    echo'<button data-id-product="'.$product['id'].'" class="addDiscount btn-text" type="button">dodaj do promocji</button>';
                            }
                        
                        echo'</td>';
                        
                        echo'
                        <td class="changeState">
                              <div class="on-off">
                              <form class="form-change-status ajax" method="post" action="/admin/ajax/changeStatus">
                                <input type="hidden" value="'.$product['id'].'" name="id">
                                <input type="radio" value="1" '.$onChecked.' name="status" class="form-control" >
                                <input type="radio" value="2" '.$offChecked.' name="status" class="form-control">
                                <div class="switch"></div>
                              </form>
                              </div>
                        </td>
                        <td class="remove">
                            <button class="no-style" type="submit">'.Svg::create('x').'</button>
                        </td>
                    </tr>';
                    }
                    ?>
                    
                    
                 </table>
                 
            </div>
        </div>


    </main>
    <?=Notification::create()?>
    <?=RemoveForm::create('remove','Potwierdzenie usunięcia','Czy na pewno chcesz usunąć produkt:', '/admin/ajax/deleteProduct')?>
    <?=productForm::create('editProduct','Edytuj dane produktu', '/admin/ajax/editProduct')?>
    <?=productForm::create('addProduct','Dodaj produkt', '/admin/ajax/addProduct')?>
    
    <div class="modal fade" id="addDiscount" tabindex="-1" role="dialog" aria-labelledby="editUserLabel" aria-hidden="true">
              <div class="modal-dialog" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Ustaw rabat</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>
                  <form class="ajax" method="post" action="/admin/ajax/addDiscountProduct">
                  <input type="hidden" name="id" class="input-custom" id="add-discount-id">
                  <div class="modal-body">
                      <div class="form-group">
                        <label for="add-discount-discount" class="form-control-label">Dodaj do promocji:</label>
                        <input type="number" name="discount" class="input-custom" id="add-discount-discount">
                      </div>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Anuluj</button>
                    <button type="submit" class="btn btn-primary">Zapisz</button>
                  </div>
                 </form>
                </div>
              </div>
            </div>
    
        <div class="modal fade" id="productGallery" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="productGalleryLabel" aria-hidden="true">
              <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                  <div class="modal-header">
                    <h5 class="modal-title" id="productGalleryLabel">Galeria zdjęć</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                      <span aria-hidden="true">&times;</span>
                    </button>
                  </div>

                  <div class="modal-body">
                  <form class="dropzone" method="post" id="imageDropzone" action="/admin/ajax/addPhotoForProduct">
                  <input type="hidden" name="id"  class="input-custom" id="productGallery-id">   
                   </form>
                  </div>
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
                  </div>
                
                </div>
              </div>
            </div>
    
    
    <?=Scripts::create(['/admin/public/js/notifications.js','/admin/public/js/formHandling.js',"/admin/public/js/tinymce/tinymce.min.js","/admin/public/js/dropzone.js"])?>
    <script>
        /*$(function()
        {
           $('#editUser').modal();
        });*/
        
        function updateClientList()
        {
            /*
                TO DO:
                Asynchronus update of table contents
             */
            
            window.location.reload();
        }
        
        
        $('.editProduct').click(function()
        {
            let userRow=$(this).parent('tr');
            let formModal=$('#editProduct');
            
            let id=userRow.data('id');
            formModal.find('#editProduct-id').val(id);
            
            let name=userRow.data('name');
            formModal.find('#editProduct-name').val(name);
            
            let productCode=userRow.data('product_code');
            formModal.find('#editProduct-product_code').val(productCode);
            
            let description=userRow.data('description');
            tinymce.get('editProduct-description').setContent(description);
            tinymce.get('editProduct-description').save();
            
            let price=userRow.data('price');
            formModal.find('#editProduct-price').val(price);
            
            let unit=userRow.data('unit');
            formModal.find('#editProduct-unit').val(unit);
            
            let quanity=userRow.data('quanity');
            formModal.find('#editProduct-quanity').val(quanity);
            
            let reservation=userRow.data('reservation');
            formModal.find('#editProduct-reservation').val(reservation);
            
            let category=userRow.data('category');
            formModal.find('#editProduct-kategoria').val(category);
            
            let discount=userRow.data('discount');
            formModal.find('#editProduct-discount').val(discount);
            
            let state=userRow.data('state');
            if(state===1)
            {
                $('#editProduct-state-on').trigger('click');
            }
            else
            {
                $('#editProduct-state-off').trigger('click');
            }
            
            let news=userRow.data('news');
            console.log(news);
            if(news===1)
            {
                $('#editProduct-news-on').trigger('click');
            }
            else
            {
                $('#editProduct-news-off').trigger('click');
            }
            
            
            formModal.modal();  
            
        });
        
        $('.addProduct').click(function()
        {
            let formModal=$('#addProduct');
            formModal.modal();  
            
        });
        
        $('.notification').on('notification-end',function()
        {
            //updateClientList();
        })
        
        $('.remove').click(function()
        {
            
        });
        
        $('.switch').click(function()
        {
           $(this).siblings('input:not(:checked)').trigger('click');
        });
        
        $('.form-change-status').change(function()
        {
            $(this).submit();
        });
        
        $('.search-product').keyup(function()
        {
            let keyword=$(this).val().toLowerCase();
            
            if(keyword.length<3)
            {
                $('.table-clients tr').fadeIn();
            }
            else
            {
                $('.table-clients tr:not(:first-of-type)').fadeOut(function()
                {
                    $('.table-clients tr').each(function()
                    {
                        let content='';
                        
                        $(this).find('td').each(function()
                        {
                           content+=$(this).text().toLowerCase(); 
                        });
                        
                        
                        console.log(content);
                        if (content.match(keyword))
                        {
                            $(this).fadeIn();
                        }
                    });
                    
                });
            }
        });
        
        $('.addDiscount').click(function()
        {
            let id=$(this).data('id-product');
            $('#add-discount-id').val(id);
            $('#addDiscount').modal('toggle');
        });
                $('.remove').click(function()
        {
            let removeForm=$('#remove');
            let row=$(this).parents('tr');
            let id=row.data('id');
            
            let name=row.data('name')+' ('+row.data('product_code')+')';
            
            removeForm.find('#remove-id').val(id);
            removeForm.find('.remove-name').text(name);
            removeForm.modal();
        });
        
        $(function()
        {
           
           $('.editGallery').click(function()
           {
               let productId=$(this).parents('tr').data('id');
               $('#productGallery').find('#productGallery-id').val(productId);
               loadPhotos(productId);
               

               $('#productGallery').modal();
           }); 
           
          
        });
        
    $('#imageDropzone').submit(function(e)
    {
        e.preventDefault();
    });

function loadPhotos(id)
{
    $('.dropzone .dz-complete').remove();
    let photos;
    $.ajax({
    'async': false,
    'type': "POST",
    'global': false,
    'dataType': 'html',
    'url': "/admin/ajax/listProductPhotos",
    'data': {id:id},
    'success': function (data) {
        photos=data;
    }
});
    let photosHtml='';
   photos=JSON.parse(photos);
    
    photos.forEach(function(photo)
    {
        console.log(photo.main_photo);
       photosHtml+=`<div data-id="`+photo.id+`" class="dz-preview dz-processing dz-image-preview dz-success dz-complete">  <div class="dz-image"><img data-dz-thumbnail="" alt="`+photo.alt+`" src="/public/images/products/`+photo.link+`"></div>  <div class="dz-details">        <div class="dz-filename"><span data-dz-name="">`+photo.link+`</span></div>  </div>  <div class="dz-progress"><span class="dz-upload" data-dz-uploadprogress="" style="width: 100%;"></span></div>  <div class="dz-error-message"><span data-dz-errormessage=""></span></div>  <div class="dz-success-mark">    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Check</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <path d="M23.5,31.8431458 L17.5852419,25.9283877 C16.0248253,24.3679711 13.4910294,24.366835 11.9289322,25.9289322 C10.3700136,27.4878508 10.3665912,30.0234455 11.9283877,31.5852419 L20.4147581,40.0716123 C20.5133999,40.1702541 20.6159315,40.2626649 20.7218615,40.3488435 C22.2835669,41.8725651 24.794234,41.8626202 26.3461564,40.3106978 L43.3106978,23.3461564 C44.8771021,21.7797521 44.8758057,19.2483887 43.3137085,17.6862915 C41.7547899,16.1273729 39.2176035,16.1255422 37.6538436,17.6893022 L23.5,31.8431458 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" stroke-opacity="0.198794158" stroke="#747474" fill-opacity="0.816519475" fill="#FFFFFF" sketch:type="MSShapeGroup"></path>      </g>    </svg>  </div>  <div class="dz-error-mark">    <svg width="54px" height="54px" viewBox="0 0 54 54" version="1.1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xmlns:sketch="http://www.bohemiancoding.com/sketch/ns">      <title>Error</title>      <defs></defs>      <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd" sketch:type="MSPage">        <g id="Check-+-Oval-2" sketch:type="MSLayerGroup" stroke="#747474" stroke-opacity="0.198794158" fill="#FFFFFF" fill-opacity="0.816519475">          <path d="M32.6568542,29 L38.3106978,23.3461564 C39.8771021,21.7797521 39.8758057,19.2483887 38.3137085,17.6862915 C36.7547899,16.1273729 34.2176035,16.1255422 32.6538436,17.6893022 L27,23.3431458 L21.3461564,17.6893022 C19.7823965,16.1255422 17.2452101,16.1273729 15.6862915,17.6862915 C14.1241943,19.2483887 14.1228979,21.7797521 15.6893022,23.3461564 L21.3431458,29 L15.6893022,34.6538436 C14.1228979,36.2202479 14.1241943,38.7516113 15.6862915,40.3137085 C17.2452101,41.8726271 19.7823965,41.8744578 21.3461564,40.3106978 L27,34.6568542 L32.6538436,40.3106978 C34.2176035,41.8744578 36.7547899,41.8726271 38.3137085,40.3137085 C39.8758057,38.7516113 39.8771021,36.2202479 38.3106978,34.6538436 L32.6568542,29 Z M27,53 C41.3594035,53 53,41.3594035 53,27 C53,12.6405965 41.3594035,1 27,1 C12.6405965,1 1,12.6405965 1,27 C1,41.3594035 12.6405965,53 27,53 Z" id="Oval-2" sketch:type="MSShapeGroup"></path>        </g>      </g>    </svg>  </div><div class="dz-options"><div class="dz-main `+(photo.main_photo==='1'?`active`:``)+` "><?=Svg::create('glowna')?></div><div class="dz-remove">&times;</div></div></div>`;
    });
    $('.dz-preview:not(.dz-complete)').remove();
    $('.dropzone').append(photosHtml);
}



Dropzone.options.imageDropzone = {
    paramName: "image",
    init : function() {

        myDropzone = this;
        
        
 $('.dropzone').sortable({revert:true,scroll:false,placeholder:'dropzone__sort-placeholder'});
        this.on("complete", function(event)
        {
            if($('.dz-preview:not(.dz-complete)').length>=0)
            {
                let id=$('#productGallery-id').val();
                loadPhotos(id);
                console.log('test');
            }  
        });
    }
};
        

    
    

    $('.dropzone').on('sortstop',function(event,ui)
    {
        savePhotosOrder();

    });

    function savePhotosOrder()
    {
        let photos=[];
        let order=1;
        $('.dz-preview').each(function()
        {
            let id=$(this).data('id');
            let photo={id:id,sort:order};
            photos.push(photo);
            order++;
        });
        
        photos=JSON.stringify(photos);
        
        $.post('/admin/ajax/setProductPhotosOrder',{photos:photos});
    }
  

    $('.dropzone').on('click','.dz-remove',function()
    {
        let photoId=$(this).parents('.dz-preview').data('id');
        emulateFormSend('/admin/ajax/deletePhoto',{id:photoId});
        $(this).parents('.dz-preview').remove();
    });
     
     $('.dropzone').on('click','.dz-main',function()
     {
         let photoId=$(this).parents('.dz-preview').data('id');
         emulateFormSend('/admin/ajax/addPhotoToMain',{id:photoId});
         $('.dz-main.active').removeClass('active');
         $(this).addClass('active');
         
     });
     
    </script>
    <script>tinyMCE.init({
                    selector:'textarea',
                    plugins:'code,preview',
                    setup: function (editor)
                    {
                        editor.on('change', function ()
                        {
                            editor.save();
                        });
                    }
                });</script>
</body>
</html>