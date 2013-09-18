$(function() 
{	
    /*$("#list").on('click','.anular',function(){
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
    });*/
    
    $("#list").on('click','.pagar',function(){
            
        var i = $(this).attr("id");
        i = i.split('_');
        id = i[1];
        fecha=i[2];
        var ventana=popup('index.php?controller=ventas&action=pagarcuota&id='+id, 'Pago de cuotas, width=600, height=600, resizable=no, scrollbars=yes, status=yes,location=yes'); 
        ventana.focus();
        //href="javascript:popup('index.php?controller=ingresom&action=detalle&id=<?php echo $id; ?>',870,350)" 
    });
    
});