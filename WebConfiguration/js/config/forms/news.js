var news = {
    connectAll : function() {
        $('#NewsProvider').change(function(){
            $("input").removeAttr("disabled");
            
            for( var n in $('#NewsProvider option:selected').attr("_disable").split(",") ) { 
                $( $('#NewsProvider option:selected').attr("_disable").split(",")[n] ).attr("disabled", "");
            };
        });
    }
};