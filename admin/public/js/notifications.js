let notification=(function()
{
    let notificationSelector=$('.notification');
    let notificationTextSelector=notificationSelector.find('.notification-text');
    let animationTime=400;
    let visibilityTime=3200;
    let notificationQueue=[];
    let isAnotherNotification=false;
    let errorClass='notification-error';
    let successClass='notification-success';
    
    
    
    
    let setErrorClass=function()
    {
        notificationSelector.removeClass(successClass);
        notificationSelector.addClass(errorClass);
    }
     
    let setSuccessClass=function()
    {
        notificationSelector.removeClass(errorClass);
        notificationSelector.addClass(successClass);
    }
    
    let setType=function(type)
    {
        if(type==="error")
        {
            setErrorClass();
        }

        if(type==="success")
        {
            setSuccessClass();  
        }
    }
    
    
    let notify=function(message, type="standard")
    {
        if(isAnotherNotification)
        {
            notificationQueue.push(message);
        }
        else
        {   
            setType(type);
            insertNotificationText(message);
            setAnimationTime();
            showNotification();
            hideNotificationAfterTime(visibilityTime); 
            triggerEndEvent(visibilityTime);

        }
    };
    
    let triggerEndEvent=function(time)
    {
        setTimeout(function()
        {
            notificationSelector.trigger('notification-end');
        },animationTime+time);
    }
    
    let insertNotificationText=function(message)
    {
        notificationTextSelector.html(message);
    };
    
    let setAnimationTime=function(time=animationTime)
    {
        animationTime=time;
        notificationSelector.css('transition','transform '+animationTime+'ms');
    };
    
    let showNotification=function()
    {
        notificationSelector.addClass('showed');
        isAnotherNotification=true;
    };
    
    let hideNotificationAfterTime=function(time)
    {
        setTimeout(function()
        {
            notificationSelector.removeClass('showed');
            isAnotherNotification=false;
            showNextNotificationIfExists();
        },animationTime+time);

    };
    
    let showNextNotificationIfExists=function()
    {
        if(isNotificationInQueue())
        {
            setTimeout(function()
            {
                notify(notificationQueue.pop());
            },animationTime);
        }

    };
    
    let isNotificationInQueue=function()
    {
        return notificationQueue.length!==0;
    }
    
    
    return{
        notify:notify,
        setAnimationTime:setAnimationTime
    };
    
})();