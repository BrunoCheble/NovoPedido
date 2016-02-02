$(document).ready(function(){
   $('.checklist input, .checklist label').live({
        click: function(){
            checklist = $(this).parents('.box-checklist');
            setInputList(checklist);
        }
    });
    
    setInputList = function(checklist){
        text = "";
        itens = checklist.find('.checklist input:checked').next('label');
        
        $.each(itens ,function(){
           text += $(this).text()+", ";
        });
        $('.input-checklist').val(text);
    }
    
    getHtmlBoxList = function(items,name){
        html  = "<div class='box-checklist'>";
            html += "<input type='text' readonly='readonly' class='input-checklist' />";
            html += "<div style='display: none' class='checklist'>";

                $.each(items, function(index, value){
                    html += "<div>";
                    attributes = "";
                    $.each(value['attributes'], function(name_attr, value_attr){
                        attributes += ""+name_attr+"='"+value_attr+"'";
                    });
                    html += "<input "+attributes+" id='Item_"+i+"' type='checkbox' name='"+name+"[]'>";
                    html += "<label for='Item_"+i+"'>"+value['attributes']["value"]+"</label>";
                    html += "</div>";
                });

            html += "<div>";
        html += "<div>";
    }
});