/**
 * Created by cemeh666 on 10.12.17.
 */

    function refreshCategoryList() {
       $.get("/api/categories", function(data) {
           if(data.status == 'Ok'){
               $("[name='categories_list']").empty();
               $.each(data.data, function(key, value) {
                   $("[name='categories_list']").append("<option value='"+value.id+"'>"+value.category_name+"</option>");
                   $("#multiselect_categories").append("<option value='"+value.id+"'>"+value.category_name+"</option>");
                   $("#multiselect_categories_goods").append("<option value='"+value.id+"'>"+value.category_name+"</option>");
               });
               $('#multiselect_categories').multiselect();
           }

       });
    }
    function getGoodsList() {
       $.get("/api/goods", function(data) {
           if(data.status == 'Ok'){
               $("[name='goods']").empty();
               $.each(data.data, function(key, value) {
                   var categories = '';
                   $.each(value.category, function (k, v) {
                       categories+=v.id+',';
                   });
                   $("[name='goods']").append("<option value='"+value.id+"' " +
                       "data-categories='"+categories+"'" +
                       "data-title='"+value.goods_title+"'" +
                       "data-description='"+value.goods_description+"'" +
                       ">"+value.goods_title+"</option>")
               });
               $("[name='goods']").trigger('change');
           }
       });
    }

    $("[name='goods']").on('change', function () {
       var categories   = $("[name='goods'] option:selected").attr('data-categories').split(',');
       var title        = $("[name='goods'] option:selected").attr('data-title').split(',');
       var description  = $("[name='goods'] option:selected").attr('data-description').split(',');
       $('#multiselect_categories_goods').multiselect('deselectAll', false);
       $('#multiselect_categories_goods').multiselect('updateButtonText');
       $('#multiselect_categories_goods').multiselect('select', categories);

       $("#goods_edit_title").val(title);
       $("#goods_edit_description").val(description);

    });

    refreshCategoryList();
    getGoodsList();
