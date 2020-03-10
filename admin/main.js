jQuery(document).ready(function($){
    $('.save').on('click', function(){
        $.post('add.php', { tip: 'vipl', data: $('.sumvivod').val()+':'+$('.numvivod').val()+':'+$('input:checked').val()})
       .done(function(data) {
        alert(data);
        });
    });
    $('.qadd').on('click', function(){
        var n = $(this).data('num');
        $.post('add.php', { tip: 'qkosh', data: n+':'+$('.qkosh'+n).val()+':'+$('.qtoken'+n).val()})
       .done(function(data) {
        //alert(data);
        var arr = $.parseJSON(data);
        if(arr['kos'] != 'no'){  
             $('.qhook'+n).val(arr['hook']);
             $('.qkey'+n).val(arr['key']);
             $('.qstatus'+n).text(arr['status']);
             $('.qbalans'+n).text(arr['sum']);
             if(arr['blok'] == 0){
                $('.qblok'+n).text('+');
             }else{
                $('.qblok'+n).text('-');
             }
             if(arr['aktiv'] == 0){
                $('.qaktiv'+n).text('неактив');
             }else{
                $('.qaktiv'+n).text('актив');
             }
             alert(arr['kos']); 
        }else{
               alert('Не смог добавить кошелек');
        }
        });
    });
    $('.gdel').on('click', function(){
        var n = $(this).data('num');
        var num = confirm("Подтверить удаление?");
        if(num === true){
        $.post('add.php', { tip: 'delkosh', data: n})
       .done(function(data) {
        alert(data);
        });
        }
    });
    $('.optopl').on('click', function(){
        $.post('edit.php', { edit: 'optopl', data: $(this).val()})
       .done(function(data) {
        alert(data);
        });
    });
    $('.viv').on('click', function(){
        var n = $(this).data('num');
        var num = confirm("Подтверить вывод?");
        if(num === true){
        $.post('vivod.php', { token: $('.qtoken'+n).val(), sum: $('.qbalans'+n).text(), num: $('.qkosh'+n).val(), numvivod: $('.numvivod').val(), tip: $('input:checked').val() })
       .done(function(data) {
        alert(data);
        });
        }
    });
    $('.reloads').on('click', function(){
        var n = $(this).data('num');
        $.post('edit.php', { edit: 'reaktiv', num: $('.qkosh'+n).val() })
       .done(function(data) {
        if(data == 0){
            $('.qaktiv'+n).text('неактив');
        }else{
            $('.qaktiv'+n).text('актив');
        }
        });
    });

    $('.save_setting').on('click', function(event){
        var empty = '{"api_domain":"'+$('.api_domain').val()+'", "offer_domain":"'+$('.offer_domain').val()+'"}';
        alert(empty);
        $.post('add.php', { tip: 'system', data: empty })
            .done(function(data) {
                alert(data);
            });
    });
    $('.save_billix').on('click', function(event){
        var empty = '{"mid":"'+$('.billix_mid').val()+'", "api_key":"'+$('.billix_api').val()+'", "secret_key":"'+$('.billix_secret').val()+'"}';
            alert(empty);
            $.post('add.php', { tip: 'billix', data: empty })
                .done(function(data) {
                    alert(data);
                });
    });
    //end billix

	$('.send').on('click', function(event){
	   var fil = $(this).data('play');
       var empty = [];
       var sum = [];
       if(fil == 'kosh'){
       for(i = 0; i < 10; i++){
        if($('#recipient-'+fil+''+(i+1)).val()){
            empty.push($('#recipient-'+fil+''+(i+1)).val());
        }
       }
       //alert(empty);
       $.post('add.php', { tip: fil, data: empty })
       .done(function(data) {
        alert(data);
        });
        }
        else{
        for(i = 0; i < 15; i++){
        if($('#recipient-'+fil+''+(i+1)).val()){
            empty.push($('#recipient-'+fil+''+(i+1)).val());
            if($('#recipient-sum'+(i+1)+'-min').val() && $('#recipient-sum'+(i+1)+'-max').val()){
                sum.push($('#recipient-sum'+(i+1)+'-min').val()+'-'+$('#recipient-sum'+(i+1)+'-max').val());
            }
        }
       }
       $.post('add.php', { tip: fil, url: empty, sum: sum })
       .done(function(data) {
        alert(data);
        });
        }
	});
    setTimeout(function qiwi() {
        $('.qiwi').each(function(i,elem) {
            if ($(this).val() == '') {
                return false;
            } else {
            $.post('edit.php', { edit: 'qiwi', zapros: 'status', num: $('.qkosh'+i).val(), token: $('.qtoken'+i).val() })
            .done(function(data) {
                //var reud = data.split(':');
                var arr = $.parseJSON(data);
                if(arr['status'] == 'blocked'){
                    
                }else{
                    $('.qstatus'+i).text(arr['status']);
                    $('.qbalans'+i).text(arr['balanse']);
                    $('.qsum'+i).text(arr['sum']);
                }
            });
            }
        });
            setTimeout(qiwi, 40000);
        }, 3000);
    setTimeout(function stata() {
       $.post('edit.php', { edit: 'stat-all' })
       .done(function(data) {
        var stat = data.split(':');
        var epc = (stat[4] / stat[0]).toFixed(2);
        if($('.open1').text() < stat[0]){playSound('opening.mp3');}
        if($('.oplata1').text() < stat[1]){playSound('opl.mp3');}
        if($('.success1').text() < stat[3]){playSound('money.mp3');}
        $('.open1').text(stat[0]);
        $('.oplata1').text(stat[1]);
        $('.sum1').text(stat[2]);
        $('.success1').text(stat[3]);
        $('.succsumm1').text(stat[4]);
        $('.epc1').text(epc);
        });
        setTimeout(stata, 3000);
        }, 3000);
        
        var sound = new Audio();
        function playSound(url){
            sound.pause();
            sound.currentTime = 0;
            sound.src = url;
            sound.play();
        }
});