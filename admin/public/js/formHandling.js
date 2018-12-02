$('body').on('submit','form.ajax',function(event)
{   
   event.preventDefault();
   action=$(this).attr('action');
   $.post(action,$(this).serialize(),function(ajaxResponse)
   {
       let notificationText=ajaxResponse;
       //$('#notification').modal('toggle');
       let responseIsJson=true;
       let decodedResponse;
       try
       {
           decodedResponse=$.parseJSON(ajaxResponse);
       }
       catch(err)
       {
           responseIsJson=false;
       }
       
       if(responseIsJson)
       {
           notification.notify(decodedResponse.text,decodedResponse.state);
           
            if($(this).data('mail') && decodedResponse.state==='success')
            {

            }
       }
       else
       {
          notification.notify(notificationText); 
       }
       

   });
   
   
   
   $('.modal:visible').modal('toggle');
    
});

$('form.ajax-file').submit(function(event)
{
    let iframe;
    do
    {
     iframe=$(this).parents('tr').find('iframe').contents().find('body').html();
    }while(iframe);
   
    
  /* action=$(this).attr('action');
   $.post(action,$(this).serialize(),function(ajaxResponse)
   {
let notificationText=ajaxResponse;
       //$('#notification').modal('toggle');
       let responseIsJson=true;
       let decodedResponse;
       try
       {
           decodedResponse=$.parseJSON(ajaxResponse);
       }
       catch(err)
       {
           responseIsJson=false;
       }
       
       if(responseIsJson)
       {
           notification.notify(decodedResponse.text,decodedResponse.state);
       }
       else
       {
          notification.notify(notificationText); 
       }
   });*/
   
   $('.modal:visible').modal('toggle');
   
});

$(function()
{
   $('.select-with-search').selectize({
    create: true,
    sortField: 'text'
});
});

function emulateFormSend(url,params)
{

    $.post(url,params,function()
    {
       let notificationText=ajaxResponse;
       //$('#notification').modal('toggle');
       let responseIsJson=true;
       let decodedResponse;
       try
       {
           decodedResponse=$.parseJSON(ajaxResponse);
       }
       catch(err)
       {
           responseIsJson=false;
       }
       
       if(responseIsJson)
       {
           notification.notify(decodedResponse.text,decodedResponse.state);
       }
       else
       {
          notification.notify(notificationText); 
       }
    });

};