$(document).on('click', '.deleteitem', function() {
    var top_level = $(this).closest(".top_level");
    $(this).closest(".clone_it").remove();
    size = $(top_level).children(".clone_it").length;
    if (size <= 1) {
        $(top_level).find('a.deleteitem').hide();
    }
    return false;
});
$(document).on('click', '.cloner', function() {
    imgcloner = false;
    if($(this).hasClass('imgcloner')) imgcloner = true;
    var field = $(this).closest(".top_level");
    ideal = $(field).children(".clone_it:last");
    clone = $(ideal).clone();
    $(clone).find('input').val('');
    $(clone).find('textarea').val('');
    $(clone).insertAfter(ideal);
    size=0;
    $(field).children('.clone_it').each(function(index){
        index = index+1;
        $(this).find("a[name='key']").attr('data-info',index);
        $(this).find('.count:first').text(index);
        $(this).find('.imageClone').hide();
        $(this).find('input').each(function(){
            if($(this).attr('type')!="file"){
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[[0-9]+\]/), "["+index+"]"));
            }
        });
        $(this).find('textarea').each(function(){
            if($(this).attr('type')!="file"){
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[[0-9]+\]/), "["+index+"]"));
            }
        });

        $(this).find('input[type=file]').each(function(){
            if(imgcloner){
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[image][[0-9]+\]/), "[image]["+index+"]"));
            }
            else{
                $(this).attr("name", $(this).attr("name").replace($(this).attr("name").match(/\[[0-9]+\]/), "["+index+"]"));
            }
        });

        size++;
    });
    if (size > 1) {
        $(field).children(".clone_it").children(".card").children(".card-header").find(".deleteitem").show();
    }
    return false;
});
$(document).on("keyup","input[name=hotel_search]",function(){
    that = $(this);
    search = $(this).val();
    if(search.length>2){
        $.get("../ajax/hotels/"+search, function( data ) {
            items = "";
            hotels = $.parseJSON(data);
            if(hotels.length>0){
                $.each(hotels,function(i,hotel){
                    console.log($(that).parent().find(".hotel_list"));
                    console.log(hotel.name);
                    items += '<li data-value="hotel:'+hotel.id+'">'+hotel.name+', '+hotel.address+'</li>';
                });
            }
            items += '<li data-same="'+search+'">Just use \''+search+'\'</li>';
            $(that).parent().find(".hotel_list ul").html(items);
            $(that).parent().find(".hotel_list").show();
        });
    }else{
        $(that).parent().find(".hotel_list").hide();
    }
});
$(document).on("click",".hotel_list li",function(){
    var attr = $(this).attr('data-same');
    if (typeof attr !== typeof undefined && attr !== false) {
        $(this).closest('.card').find('.end_of_day').val($(this).attr("data-same"));
        $(this).closest('.card').find('input[name=hotel_search]').val($(this).attr("data-same"));
    }else{
        $(this).closest('.card').find('.end_of_day').val($(this).attr("data-value"));
        $(this).closest('.card').find('input[name=hotel_search]').val($(this).text());
    }
    $(this).closest('.hotel_list').hide();
});
