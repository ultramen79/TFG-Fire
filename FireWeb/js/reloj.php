var tiempo=new Date(<?php echo round(microtime(true) * 1000); ?>);
var dias = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sábado"];
var meses = ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];
var anio = tiempo.getFullYear();
var dia = tiempo.getDate();
var diaSemana = dias[tiempo.getDay()];
var mes = meses[tiempo.getMonth()];
setInterval(displayclock,1000);
function displayclock (){
    var horas = tiempo.getHours();
    var minutos = tiempo.getMinutes();
    var segundos = tiempo.getSeconds();
    if( horas < 10){
        horas = '0' + horas;
    }
    if( minutos < 10 ){
        minutos = '0' + minutos;
    }
    if( segundos <10 ){
        segundos = '0' + segundos;
    }
    tiempo.setSeconds(tiempo.getSeconds()+1);
    document.getElementById('reloj').innerHTML = diaSemana + ' ' + dia +' de '+mes + ' del '+ anio +' ' + horas + ':' + minutos + ':' + segundos;
}
