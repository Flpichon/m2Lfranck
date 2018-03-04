function ok()
{
    alert('vous êtes connecté');
}


function popup($des,$titr) {
    // ouvre une fenetre sans barre d'etat, ni d'ascenceur
    w=open('fiche formation.html','popup','width=400,height=400,toolbar=no,scrollbars=no,resizable=yes');
    w.document.write("<title>"+$titr+"</title>");	
    w.document.write("<body>"+$des+"</body>");
    
    w.document.close();
  }


    
    function ajouterzero(i)
    {   ;
        if (i < 10) {
            i = "0" + i;
        }
        return i;
    }
        
       function horloge() 
       {    var boite = document.element = document.getElementById("heure"); // variable objet
           var heure =new Date();
           boite.textContent = "Il est " + ajouterzero(heure.getHours())+":"+ajouterzero(heure.getMinutes())+":"+ajouterzero(heure.getSeconds());
           setInterval("horloge()", 10000);
       }
       
  