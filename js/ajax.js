function getXHR(){
    var reqHTTP;
    if(window.XMLHttpRequest){
        reqHTTP = new XMLHttpRequest();
        if(reqHTTP.overrideMimeType){
            reqHTTP.overrideMimeType('text/plain');
        }
    }else{
        reqHTTP=null;
    }
    return reqHTTP;
}
// envoi de myNAME et myTXT
function uploadContent(TheURL,idutil,TheContent){
    // création de l'objet de communication XHR
    var XHR = getXHR();
    // on prend la valeur de TheName
    var id = idutil;
    // on prend la valeur de TheContent
    var content = document.getElementById(TheContent).value;
    // ouverture du fichier serveur en mode POST asynchrone
    XHR.open("POST",TheURL,true);
    // écouteur (appel la fonction anonyme à chaque changement d'état de l'objet XHR)
    XHR.onreadystatechange=function(){
        // si on a récupéré le résultat
        if(XHR.readyState==4 && XHR.status==200){
            // on vérifie la réponse venant de phpAjax/insert.php
            switch(XHR.responseText) {
                case "0":
                    alert("Problème d'existance d'une variable de type POST");
                    break;
                case "1":
                    alert("Problème: un de vos champs est vide ou non valide");
                    // on vide TheContent
                    document.getElementById(TheContent).value="";
                    break;
                case "2":
                    alert("Problème lors de l'insertion dans la base de donnée, vous pouvez réessayer");
                    break;
                default:
                    // chargement des contenus venant de la db dans le div content
                    chargeContent('../phpAjax/recup.php','headercontent');
                    // on vide TheContent
                    document.getElementById(TheContent).value="";
            }
        }
    }
    // entête obligatoire pour de l'ajax en post
    XHR.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    // envoi de nos variable POST
    XHR.send("n="+id+"&c="+content);
}
// récupération des données
function chargeContent(URL,idDiv){
    var XHR = getXHR();
    if(XHR==null){
        alert("Ajax ne fonctionne pas avec votre navigateur");
        return ;
    }
    // ajax en mode POST asynchrone
    XHR.open('POST',URL,true);
    // écouteur
    XHR.onreadystatechange=function(){
        afficheContent(XHR,idDiv);
    }
    // entête obligatoire pour de l'ajax en post
    XHR.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
    XHR.send();
}
// affichage des commentaires
function afficheContent(objXHR,idDuDiv){
    if(objXHR.readyState==4&& objXHR.status==200){
        document.getElementById(idDuDiv).innerHTML= objXHR.responseText;
        var getHeight = document.getElementById(idDuDiv).scrollHeight;
        document.getElementById(idDuDiv).scrollTop=getHeight;
        //console.log(getHeight);
    }
}
// vérification si un nouveau commentaire a été posté par un autre utilisateur
function verifContenu(verif,recup,idcontent){
    var XHR = getXHR();
    XHR.open("GET",verif,true);
    XHR.onreadystatechange=function(){
        if(XHR.readyState==4&& XHR.status==200){
            // si il y a un nouveau commentaire
            if(XHR.responseText=="change"){
                // chargement des contenus venant de la db dans le div content
                chargeContent(recup,idcontent);
            }
        }
    }
    XHR.send();
}
