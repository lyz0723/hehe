 
        $(function(){
            var aA=$('#register h3 a');
            var aUl=$('#register ul');

            aA.click(function(){
                aA.removeClass('register_btn');
                aUl.removeClass('register_show');

                $(this).addClass('register_btn');
                // alert($(this).index());
                aUl.eq($(this).index()).addClass('register_show');
            });

        });
 