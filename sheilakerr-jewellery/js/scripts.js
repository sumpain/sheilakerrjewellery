jQuery(".woo-search a").click(function(){
    jQuery(".woo-header-search-form").slideToggle();
    return false;
});
jQuery(".woo-header-search-form span.search-close").click(function(){
    jQuery(".woo-header-search-form").slideToggle();
    return false;
});

function bb_social_share(url){
    var left = (screen.width/2)-(648/2);
    var top = (screen.height/2)-(395/2);
    window.open(url,'sharer','toolbar=0,status=0,width=648,height=395, top='+top+', left='+left);
    return true;
}