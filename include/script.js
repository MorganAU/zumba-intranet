function verifInputName(champ)
{
	if (champ.value.length < 2) {
		alert('Le champ "' + champ["placeholder"] + '" est trop court');
		error(champ, true);
		add();
		return false;
	} else if (champ.value.length > 18) { 
		alert('Le champ "' + champ["placeholder"] + '" est trop long');
		error(champ, true);
		return false;
	} else {
		error(champ, false);
		return true;
	}
}

function error(champ, erreur)
{
	if(erreur) {
		champ.style.backgroundColor = "red";
	} else {
		champ.style.backgroundColor = "";
	}
}


function add()
{/*
	var para = document.createElement('p');
	para.id = 'error';
	var text = document.createTextNode('error');
	para.appendChild(text);
	var divError = document.querySelector('.div-error');					
	console.log(divError.getAttibute('class'));					
	document.body.sectio.divError.insertBefore(para, divError);*/
	 // crée un nouvel élément div
  var newDiv = document.createElement("div");
  // et lui donne un peu de contenu
  var newContent = document.createTextNode('Hi there and greetings!');
  // ajoute le nœud texte au nouveau div créé
  newDiv.appendChild(newContent);
  
  // ajoute le nouvel élément créé et son contenu dans le DOM
  var currentDiv = document.getElementById('for-error');
  console.log(currentDiv);
  console.log(newDiv);
  document.body.section.insertBefore(newDiv, currentDiv);
}