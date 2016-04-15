jQuery(function ($) {

    var travel = ["/"]
    var travelPointer = 0;


    var makeCallDir = function(){
        $(".ext_dir").siblings("a").each(function() {
          $( this ).click(function() {

              if($(this).text()==".."){
                travelPointer--;
              }else{
                travelPointer++;
                travel[travelPointer] = $(this).attr("rel");
              }


            ajaxCall($(this).attr("rel"));
          });
        });
        console.log(travel)
        console.log(travelPointer);
    }

    var ajaxCall = function(getDir){
        $.ajax({
          method: "POST",
          url: DMFB.ajax_url,
          data: { dir:getDir }
        })
        .done(function( msg ) {
            printToTable(msg);
            makeCallDir();
        });
    }

    var printToTable = function(html){
        $('#DMFB_FileBrowser > tbody').empty();
        $('#DMFB_FileBrowser > tbody').append(html);
        addBackTR();
    }

    var addBackTR = function(){

        if (travel[travelPointer]!="/"){
          $('#DMFB_FileBrowser > tbody').prepend('<tr> \
                        <td> \
                          <div class="ext_dir"></div> \
                          <a rel="' +travel[travelPointer-1]+ '" href="#">..</a><br/> \
                        </td> \
                        <td class="hidden-xs"></td> \
                      </tr>')
        }
    }

    // Init
    ajaxCall("/");
});
