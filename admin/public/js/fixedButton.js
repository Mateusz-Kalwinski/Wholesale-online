 function addToStoreFixed()
        {
            let content=$('.main-content');
            let contentBottomEdge=parseInt(content.offset().top+content.innerHeight());
            let contentTopEdge=parseInt(content.offset().top);

            let scrollPos=parseInt($(window).scrollTop());
            let windowHeight=parseInt($(window).innerHeight());
            let windowBottomEdge=scrollPos+windowHeight;

            let button=$('.add-to-store');

            console.log('Content bottom:'+contentBottomEdge);
            console.log('Window bottom:'+windowHeight);

            if(contentBottomEdge<windowBottomEdge)
            {
               button.css('position','static');
               button.css('left','auto');
               button.css('right','');
               button.css('bottom',20);
            }
            else
            {
                if(contentTopEdge-200<scrollPos)
                {
                    button.css('position','fixed');
                    button.css('bottom','0');
                    button.css('right','auto');
                    contentRight=content.offset().left+content.innerWidth();

                    button.css('left',contentRight-button.innerWidth()-40);
                }
                else
                {
                    button.css('position','static');
                    button.css('float','right');
                    button.css('top','auto');
                    button.css('left','auto');
                    button.css('right','');
                    button.css('bottom',20); 
                }

            }
        }

        $(function()
        {
            addToStoreFixed();
            $(window).scroll(addToStoreFixed);

        });