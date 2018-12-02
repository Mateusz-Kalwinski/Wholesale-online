<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'],$data['user']['cartQuanity'])?>
    <?=navMenu::create($data['menu'])?>
    
    <main class="content">
        <div class="main-content">
        </div>
    </main>

    <div class="modal fade show" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header d-flex justify-content-center">
        <h5 class="modal-title text-center" id="exampleModalLabel"><?=$data['notification']['title']?></h5>

      </div>
      <div class="modal-body text-center">
        <?=$data['notification']['text']?>
      </div>
    </div>
  </div>
</div>
    
    <?=Scripts::create()?>
    <script>
        $(function()
        {
            $('#exampleModal').modal({
                backdrop: 'static',
                keyboard: false
            })
           $('#exampleModal').modal('show'); 
        });
        
    </script>

</body>
</html>
