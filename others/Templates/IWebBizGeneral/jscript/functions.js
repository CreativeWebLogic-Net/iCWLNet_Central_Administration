// JavaScript Document
var Country;

function js_in_array(the_needle, the_haystack){
	var the_hay = the_haystack.toString();
	if(the_hay == ''){
		return false;
	}
	var the_pattern = new RegExp(the_needle, 'g');
	var matched = the_pattern.test(the_haystack);
	return matched;
}

function toDollarsAndCents(n) {
  var s = "" + Math.round(n * 100) / 100;
  var i = s.indexOf('.');
  if (i < 0) return s + ".00";
  var t = s.substring(0, i + 1) + s.substring(i + 1, i + 3);
  if (i + 2 == s.length) t += "0";
  return t;
}

function setDelivery(CID,InitCountry){
	var Total=(document.frmCheckout.Total.value*1);
	var Delivery=0;
	if(InitCountry==CID){
		Delivery=document.frmCheckout.DN.value*1;
	}else{
		Delivery=document.frmCheckout.DI.value*1;
	}
	for(x=0;x<TaxSystems.length;x++){
		var Target=document.getElementById("TaxTotal"+x);
		var Cntry=js_in_array(CID,TaxSystemCountries[x]);
		if(Cntry){
			if(TaxSystems[x]['Modifier']=="Percent"){
				if(TaxSystems[x]['Applied']=="Exclusive"){
					var TaxAmnt=(Total+Delivery)*(TaxSystems[x]['Amount']/100);
					Total+=TaxAmnt;
					Target.innerHTML=toDollarsAndCents(TaxAmnt);
				}else{
					var TaxAmnt=(Total+Delivery)/(10+(TaxSystems[x]['Amount']/10));
					Target.innerHTML=toDollarsAndCents(TaxAmnt);
				}
				
			}else{
				var TaxAmnt=TaxSystems[x]['Amount']*document.getElementById("SetCount").value;
				Target.innerHTML=toDollarsAndCents(TaxAmnt);
				
				if(TaxSystems[x]['Applied']=="Exclusive"){
					Total+=TaxAmnt;
				}
				//alert(Total+"-"+Delivery+"-"+TaxAmnt);
			}
			document.getElementById("TaxRow"+x).style.display="";	
			
		}else{
			document.getElementById("TaxRow"+x).style.display="none";	
		}
		
	}
	
	Total+=(Delivery*1);
	document.getElementById("DeliveryTotal").value=Delivery;
	document.getElementById("DeliverySpan").innerHTML=toDollarsAndCents(Delivery);
	document.getElementById("FinalTotal").innerHTML=toDollarsAndCents(Total);
}

function MM_findObj(n, d) { //v4.01
  var p,i,x;  if(!d) d=document; if((p=n.indexOf("?"))>0&&parent.frames.length) {
    d=parent.frames[n.substring(p+1)].document; n=n.substring(0,p);}
  if(!(x=d[n])&&d.all) x=d.all[n]; for (i=0;!x&&i<d.forms.length;i++) x=d.forms[i][n];
  for(i=0;!x&&d.layers&&i<d.layers.length;i++) x=MM_findObj(n,d.layers[i].document);
  if(!x && d.getElementById) x=d.getElementById(n); return x;
}

function YY_checkform() { //v4.71
//copyright (c)1998,2002 Yaromat.com
  var a=YY_checkform.arguments,oo=true,v='',s='',err=false,r,o,at,o1,t,i,j,ma,rx,cd,cm,cy,dte,at;
  for (i=1; i<a.length;i=i+4){
    if (a[i+1].charAt(0)=='#'){r=true; a[i+1]=a[i+1].substring(1);}else{r=false}
    o=MM_findObj(a[i].replace(/\[\d+\]/ig,""));
    o1=MM_findObj(a[i+1].replace(/\[\d+\]/ig,""));
    v=o.value;t=a[i+2];
    if (o.type=='text'||o.type=='password'||o.type=='hidden'){
      if (r&&v.length==0){err=true}
      if (v.length>0)
      if (t==1){ //fromto
        ma=a[i+1].split('_');if(isNaN(v)||v<ma[0]/1||v > ma[1]/1){err=true}
      } else if (t==2){
        rx=new RegExp("^[\\w\.=-]+@[\\w\\.-]+\\.[a-zA-Z]{2,4}$");if(!rx.test(v))err=true;
      } else if (t==3){ // date
        ma=a[i+1].split("#");at=v.match(ma[0]);
        if(at){
          cd=(at[ma[1]])?at[ma[1]]:1;cm=at[ma[2]]-1;cy=at[ma[3]];
          dte=new Date(cy,cm,cd);
          if(dte.getFullYear()!=cy||dte.getDate()!=cd||dte.getMonth()!=cm){err=true};
        }else{err=true}
      } else if (t==4){ // time
        ma=a[i+1].split("#");at=v.match(ma[0]);if(!at){err=true}
      } else if (t==5){ // check this 2
            if(o1.length)o1=o1[a[i+1].replace(/(.*\[)|(\].*)/ig,"")];
            if(!o1.checked){err=true}
      } else if (t==6){ // the same
            if(v!=MM_findObj(a[i+1]).value){err=true}
      }
    } else
    if (!o.type&&o.length>0&&o[0].type=='radio'){
          at = a[i].match(/(.*)\[(\d+)\].*/i);
          o2=(o.length>1)?o[at[2]]:o;
      if (t==1&&o2&&o2.checked&&o1&&o1.value.length/1==0){err=true}
      if (t==2){
        oo=false;
        for(j=0;j<o.length;j++){oo=oo||o[j].checked}
        if(!oo){s+='* '+a[i+3]+'\n'}
      }
    } else if (o.type=='checkbox'){
      if((t==1&&o.checked==false)||(t==2&&o.checked&&o1&&o1.value.length/1==0)){err=true}
    } else if (o.type=='select-one'||o.type=='select-multiple'){
      if(t==1&&o.selectedIndex/1==0){err=true}
    }else if (o.type=='textarea'){
      if(v.length<a[i+1]){err=true}
    }
    if (err){s+='* '+a[i+3]+'\n'; err=false}
  }
  if (s!=''){alert('The required information is incomplete or contains errors:\t\t\t\t\t\n\n'+s)}
  document.MM_returnValue = (s=='');
  if(!document.MM_returnValue){
	  try{
			ev = window.event;
			ev.returnValue=false;
			ev.preventDefault(true);
			return false;
		}
		catch(e)
		{
			return false;
		}
  }
}

function MM_openBrWindow(theURL,winName,features) { //v2.0
  window.open(theURL,winName,features);
}

function ToggleVis(element,button,offtext,ontext){
	var Target=document.getElementById(element);
	var TargetBut=document.getElementById(button);
	if(Target.style.display==""){
		Target.style.display="none";
		TargetBut.value=offtext;
	}else{
		Target.style.display="";
		TargetBut.value=ontext;
	} 
}

