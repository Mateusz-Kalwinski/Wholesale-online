<!DOCTYPE html>
<html>
<?=Head::create()?>
<body>
    <?=Header::create($data['user']['mail'], $data['configLogo'][0]['value'])?>
    <?=navMenu::create()?>
    <main class="content">
        <div class="main-container">
           <div class="main-content ">
               <div class="content-title">
                <?=Svg::create('kategoria')?>
                    <div class="content-title-text">
                        <h4>Kategorie</h4>
                        <p>Drzewo kategorii</p>
                    </div>
                </div>
               <div class="table-panel">
                   <div></div>
                    <button class="btn addCategory">dodaj kategorię</button>
                 </div>
                <?php
                function readCategories($categoriesLevel)
                {
                    foreach($categoriesLevel as $category)
                    {
                        echo'<div data-state="'.$category['stan'].'" data-name="'.$category['name'].'" data-id="'.$category['id'].'" class="category-edit" >';
                        
                        if(!empty($category['subcategories']))
                        {
                            echo '<div data-id-parent="'.$category['id'].'" class="categories-sort">';
                            readCategories($category['subcategories']);
                            echo '</div>';
                        }
                        else
                        {
                            echo '<div data-id-parent="'.$category['id'].'" class="categories-sort"></div>';
                        }
                            echo '<div class="category-edit__title">';
                                echo '<span class="category-edit__icon_edit">'.Svg::create('edit').'</span>';
                                echo '<span class="category-edit__name">'.$category['name'].'</span>';
                                echo '<div class="category-edit__icon_caret">'.Svg::create('strzalka').'</div>';
                                 echo '<div class="category-edit__icon_remove">'.Svg::create('x').'</div>';  
                            echo '</div>';
                        
                        
                        
                        
                        echo '</div>';
                    }

                }
                 ?>
                 <div data-id-parent="0" class="categories-sort"><?=readCategories($data['categories']);?></div>

            </div>
        </div>
    </main>
    <?=RemoveForm::create('remove','Potwierdzenie usunięcia','Czy na pewno chcesz usunąć kategorię:', '/admin/ajax/deleteCategory')?>
    <?= CategoryForm::create('editCategory','Edycja kategorii', '/admin/ajax/editCategory',$data['categories'])?>
    <?= CategoryForm::create('addCategory','Dodaj kategorię', '/admin/ajax/addCategory',$data['categories'])?>
    <?=Scripts::create(['/admin/public/js/notifications.js','/admin/public/js/formHandling.js','/admin/public/js/jquery-ui.min.js'])?>
    <script src="/admin/public/js/categories.js"></script>
</body>
</html>
