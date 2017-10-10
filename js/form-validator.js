/*
 * text input charcount limiter
 * 
 * implementation:
 * inside the input tag, place this : onKeyDown="limitText(this.form.contenido,X);"
 * contenido = the "name" of the input
 * X = max characters
 */

function limitText(limitField, limitNum) {
    if (limitField.value.length > limitNum) {
            limitField.value = limitField.value.substring(0, limitNum);
    }
}

function locationValidation(userType,provincia,poblacion){
    if (userType.value=="0"){
        return true;
    }
    if (provincia.value==null||poblacion.value==null){
        return false;
    }
    return false;
}

function inputClear(checkHolder){
   
        $(checkHolder).hide();
        checkHolder.innerHTML="";
   
    return;
}


function noVoidValidator(cadena,checkHolder){
    if (cadena==""){
        $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
    }else{
        $(checkHolder).show()
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/tick.jpg' />"){
            return true;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/tick.jpg' />";
        return true;
    }
    
}

function stringValidator(cadena,checkHolder){
    var allowed="abcdefghijklmnoñpqrstuvwxyzABCDEFGHIJKLMNÑOPQRSTUVWXYZ";
    if (cadena.length!=strspn(cadena,allowed)||(cadena=="")){
        $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
    }else{
        $(checkHolder).show()
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/tick.jpg' />"){
            return true;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/tick.jpg' />";
        return true;
    }
        
}

function numberValidator(numero,checkHolder){
    if ($.isNumeric(numero)==false){
        $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
    }else{
        $(checkHolder).show()
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/tick.jpg' />"){
            return true;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/tick.jpg' />";
        return true;

    }
    
}
function keyCostValidator(money,paquetes,checkHolder){   //paquetes = cantidad de paquetes de calves, siendo paquete el volumen
    if (money<COSTO_CLAVES*VOLUMEN_CLAVES*paquetes){
        numberPositiveValidator(money,checkHolder);
        return false;
    }else{
        numberPositiveValidator(money,checkHolder);
        return true;
    }
}


function purchaseValidator(saldo,importe){
    parseInt(importe);
    importe=parseFloat(importe*COSTO_CLAVES);
    if (saldo>=importe){
        return true;
    }else{
    
        return false;
    }
}



/*
 *what= ingreso /traspaso
 */
function saldoValidator(money,what,checkHolder){
   switch(what){
       case "ingreso":
           if (money<INGRESO_MINIMO){
               return numberPositiveValidator(-1,checkHolder);
               
           }else{
               return numberPositiveValidator(money,checkHolder);
               
           }
           break;
       case "traspaso":
           if (money<TRASPASO_MINIMO){
               return numberPositiveValidator(-1,checkHolder);
               
           }else{
               return numberPositiveValidator(money,checkHolder);
               
           }
   }
}

function numberPositiveValidator(numero,checkHolder){
    if ($.isNumeric(numero)==false || ($.isNumeric(numero)&&(numero<0))){
        $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
    }else{
        $(checkHolder).show()
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/tick.jpg' />"){
            return true;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/tick.jpg' />";
        return true;

    }
}

function isValidEmailAddress(emailAddress){
    var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    return pattern.test(emailAddress);
}


function emailValidator(value,checkHolder){
    if( !isValidEmailAddress( value ) ) {
        $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
    }else{
        $(checkHolder).show()
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/tick.jpg' />"){
            return true;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/tick.jpg' />";
        return true;

    }
}

/*
 * Esto impide que el usuario sea menor de 18 años a la fecha
 */
function dateValidator(day,month,year,checkHolder){
    if (day==null || month==null || year == null){
       $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
    }    
        
     if ((!$.isNumeric(day))||(!$.isNumeric(month))||(!$.isNumeric(year))) {    
        $(checkHolder).show();
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
            return false;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
        return false;
     }
     
     var today = new Date();
     var dd = today.getDate();
     var mm = today.getMonth()+1; //January is 0!

     var yyyy = today.getFullYear();
     if(dd<10){dd='0'+dd} if(mm<10){mm='0'+mm} today = mm+'-'+dd+'-'+yyyy;
     
       
       if (year<=0 || year>yyyy ||(year==yyyy)&&(month>mm || (month==mm && day>dd))){
            $(checkHolder).show();
            if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
                return false;
            }
            checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
            return false;
       }
       if (day<=0||day>31||month<=0||month>12){
               $(checkHolder).show();
                if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/cross.jpg' />"){
                    return false;
                }
                checkHolder.innerHTML="<img src='"+SITE_URL+"img/cross.jpg' />";
                return false;
       }
       
       $(checkHolder).show()
        if (checkHolder.innerHTML=="<img src='"+SITE_URL+"img/tick.jpg' />"){
            return true;
        }
        checkHolder.innerHTML="<img src='"+SITE_URL+"img/tick.jpg' />";
        return true;
   
    
}


function strspn (str1, str2, start, lgth) {
  var found;
  var stri;
  var strj;
  var j = 0;
  var i = 0;

  start = start ? (start < 0 ? (str1.length + start) : start) : 0;
  lgth = lgth ? ((lgth < 0) ? (str1.length + lgth - start) : lgth) : str1.length - start;
  str1 = str1.substr(start, lgth);

  for (i = 0; i < str1.length; i++) {
    found = 0;
    stri = str1.substring(i, i + 1);
    for (j = 0; j <= str2.length; j++) {
      strj = str2.substring(j, j + 1);
      if (stri == strj) {
        found = 1;
        break;
      }
    }
    if (found != 1) {
      return i;
    }
  }

  return i;
}



///////////////AJAX /////////////////////

function ajaxUserValidator( email,id,tipo_id,movil ){
    
    $.ajax({
	type	 : "GET",
        url      : SITE_URL+"controls/ajax-user.php",
        data 	 : 'email='+email+'&id='+id+'&tipo_id='+tipo_id+'&movil='+movil,
        dataType : 'text',
        async:  false,
        success	 : function( d ){ 
            if( d=="1"){
                return true;
            }else{
                return false;
            }
        }
    });
    
    return ;
}