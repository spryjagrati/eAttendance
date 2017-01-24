
function _timer(time)
{
    var time;     //  The default time of the timer
    var mode = 1;     //    Mode: count up or count down
    var status = 0;    //    Status: timer is running or stoped
    var timer_id;    //    This is used by setInterval function   
    // this will start the timer ex. start the timer with 1 second interval timer.start(1000) 
    this.start = function(interval)
    { 
        $('#start_btn').attr('disabled','disabled');
        if(time == 0){
            $.ajax({
            type:"POST",
            url:'startTime',
            data:{in:''},
            success:function(response){                 
                if(response == 'disable'){                                                        
                }
                else{                   
                }   
            }
            });
        }       
        interval = (typeof(interval) !== 'undefined') ? interval : 1000; 
        if(status == 0)
        {
            status = 1;
            timer_id = setInterval(function()
            {
                switch(mode)
                {
                    default:
                    if(time)
                    {
                        time--;
                        generateTime();
                        if(typeof(callback) === 'function') callback(time);
                    }
                    break;                    
                    case 1:
                    if(time < 86400)
                    {                       
                        if(time == 3600){
                            location.reload(); 
                        }  
                        time++;
                        generateTime();
                        if(typeof(callback) === 'function') callback(time);
                    }
                    break;
                }
            }, interval);
        }
    }
    
    //  Same as the name, this will stop or pause the timer ex. timer.stop()
    this.stop = function()
    {
        if(time > 0){
            $.ajax({
                type:"POST",
                url:'stopTime',
                data:{in:''},
                success:function(response){                           
                    if(response == 'disable'){ 
                        clearInterval(timer_id); 
                          location.reload();                             
                    }
                    else{
                    }   
                }
            });
        }
        if(status == 1)
        {
            status = 0;
            clearInterval(timer_id);
        }
    }   
   
    
    // Change the mode of the timer, count-up (1) or countdown (0)
    this.mode = function(tmode)
    {
        mode = 1;
    }
    
    // This methode return the current value of the timer
    this.getTime = function()
    {
        return time;
    }
    
    // This methode return the current mode of the timer count-up (1) or countdown (0)
    this.getMode = function()
    {
        return mode;
    }
    
    // This methode return the status of the timer running (1) or stoped (1)
    this.getStatus
    {
        return status;
    }
    
    // This methode will render the time variable to hour:minute:second format
    function generateTime()
    {       
        var second = time % 60;
        var minute = Math.floor(time / 60) % 60;
        var hour = Math.floor(time / 3600) % 60;
        
        second = (second < 10) ? '0'+second : second;
        minute = (minute < 10) ? '0'+minute : minute;
        hour = (hour < 10) ? '0'+hour : hour;
        
        $('div.timer span.second').html(second);
        $('div.timer span.minute').html(minute);
        $('div.timer span.hour').html(hour);
        $('#clockDisplay').val(time); 

        var oldtime=$('#totalhour').val();
        
        //var oldtime = old.getSeconds();
        if(oldtime !== ''){            
            var total=parseInt(time) + parseInt(oldtime); 
        }
        else{
             var total=parseInt(time);    
        }
        var second1 = total % 60;
        var minute1 = Math.floor(total / 60) % 60;
        var hour1 = Math.floor(total / 3600) % 60;

        second1 = (second1 < 10) ? '0'+second1 : second1;
        minute1 = (minute1 < 10) ? '0'+minute1 : minute1;
        hour1 = (hour1 < 10) ? '0'+hour1 : hour1;

        $('span#text-muted').html(hour1+':'+minute1+':'+second1);       
    }
}
 
// example use
var timer;
 
$(document).ready(function(e) 
{
    var val=$('#clockDisplay').val();   
    timer = new _timer(val);
  
    if(val > 0){
        if(val < 3600){  
            $('#start_btn').attr('disabled','disabled');
        }
        else{            
            $('#start_btn').addClass('hide');
            $('#stop_btn').removeClass('hide');
        }
        timer.start(1000);
    }  
});