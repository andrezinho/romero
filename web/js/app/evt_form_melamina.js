$(function() 
{    
    $( "#tipoproducto" ).focus();       
    $( "#idlinea" ).css({'width':'210px'});
    //load_maderba($('#idlinea').val());
    $( "#idmaderba" ).css({'width':'180px'});
    $( "#idunidad_medida" ).css({'width':'210px'});
    $("#idlinea").change(function(){load_maderba($(this).val());});
    $("#estados").buttonset();
    
    //Linea
    $("#box-frm-linea").dialog({
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true,
      title:'Formulario de Linea',
      buttons: {'Registrar Linea':function(){save_linea();}}
    });
    
    $("#frm_melamina").on('click','#newLine',function(){
        $.get('index.php?controller=Linea&action=create',function(html)
        {           
           $("#box-frm-linea").empty().append(html);
           $("#box-frm-linea").dialog("open");
           $("#descripcion").focus();
           
        });
    })

    //Madeba
    $("#box-frm-maderba").dialog({
      modal:true,
      autoOpen:false,
      width:'auto',
      height:'auto',
      resizing:true,
      title:'Formulario de Maderba',
      buttons: {'Registrar Maderba':function(){save_maderba();}}
    });

    $("#frm_melamina").on('click','#newMaderba',function(){
        $.get('index.php?controller=Maderba&action=create',function(html)
        {           
           $("#box-frm-maderba").empty().append(html);
           $("#box-frm-maderba").dialog("open");
           $("#descripcion").focus();
          
        });
    })
});

function load_maderba(idmad)
{
  if(idmad!="")
  {    
    $("#idmaderba").empty().append('<option value="">Cargando...</option>');
    $.get('index.php','controller=maderba&action=getList&idmad='+idmad,function(r){    
      html = '<option value="">Seleccione...</option>';
      $.each(r,function(i,j){
        html += '<option value="'+j.idmaderba+'">'+j.descripcion+'</option>';
      });      
      $("#idmaderba").empty().append(html);
    },'json');
  }
}

function save_linea()
{
    bval = true;        
    bval = bval && $( "#descripcion" ).required();
    if(bval)    
    {
       var str = $("#frm").serialize();       
       $.post('index.php',str,function(res)
       {
          if(res[0]==1)
          {
             $("#idlinea").append('<option value="'+res[2]+'">'+$("#descripcion").val()+'</option>');
             $("#box-frm-linea").dialog('close');
             $("#idmadinea").val(res[2]);
          }
       },'json');
    }
}

function save_maderba()
{
    bval = true;        
    bval = bval && $( "#descripcion" ).required();
    if(bval)    
    {
       var str = $("#frm_maderba").serialize();       
       $.post('index.php',str,function(res)
       {
          if(res[0]==1)
          {
             $("#idmaderba").append('<option value="'+res[2]+'">'+res[3]+'</option>');
             $("#box-frm-maderba").dialog('close');
             $("#idmaderba").val(res[2]);
          }
       },'json');
    }
}

function save()
{
  bval = true;        
  bval = bval && $( "#idlinea" ).required();
  bval = bval && $( "#idmaderba" ).required();        
  bval = bval && $( "#idunidad_medida" ).required();
  var str = $("#frm_melamina").serialize();
  if ( bval ) 
  {
      $.post('index.php',str,function(res)
      {
        if(res[0]==1)
        {
          $("#box-frm").dialog("close");
          gridReload();
        }
        else
        {
          alert(res[1]);
        }
        
      },'json');
  }
  return false;
}