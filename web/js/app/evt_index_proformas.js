$(function() 
{	
    $("#list").on('click','.anular',function(){
            if(confirm('Realmente deseas anular este ingreso?'))
            {
                    var i = $(this).attr("id");
                    i = i.split('-');
                    i = i[1];
                    $.post('index.php','controller=proformas&action=anular&i='+i,function(r)
                    {
                            if(r[0]==1)	gridReload();
                                    else alert('Ha ocurrido un error, vuelve a intentarlo.');
                    },'json');
            }
    });
    
    $("#list").on('click','.imprimir',function(){
            
        var i = $(this).attr("id");
        i = i.split('-');
        id = i[1];
        var ventana=window.open('../view/proformas/_pdf.php?id='+id, 'Imprimir Proforma, width=600, height=600, resizable=no, scrollbars=yes, status=yes,location=yes'); 
        ventana.focus();
        
    });
    
});