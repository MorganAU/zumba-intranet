/** Liste des fonctions JavaScript pour les formulaires
	*	verifInputText(input) --------------> Fonction pour vérifier les valeurs des input du formulaire
	*	inputTestIsNumber(input) -----------> Fonction pour vérirfier si les valeurs saisies sont bien des chiffres
	*	inputTestIsEmail(input) ------------> Fonction pour vérirfier si les valeurs saisies sont bien au format mail
	*	inputTestSize(input) ---------------> Fonction pour vérirfier la taille des valeurs saisies
	*	error(champ, erreur) ---------------> Fonction pour changer le bckground du champ si il y a une erreur
	*	changeClassAndMessage(sName, sMessage, result)-> Fonction qui renvoie les messages d'erreur en fonction de celles-ci
	*	getParaIndex(aElements, sName) -----> Fonction qui renvoie l'indes d'un élément
	*	verifAllForm() ---------------------> Fonction pour vérifier tout le formulaire quand le bouton valoider est pressé
	**/



function verifInputText(input)
{
	var sizeText = input.value.length;
	var name = input.name;


	if (name == 'status') {
		if (inputTestIsSelect(input) === false) {
			return false;
		}
	}

	if (sizeText != 0) {
		if (name == 'phone' || name == 'cp') {
			if (inputTestIsNumber(input) === false) {
				return false;
			}
		}

		if (name == 'email') {
			if (inputTestIsEmail(input) === false) {
				return false;
			}
		}

		
		if (inputTestSize(input) === false) {
			return false;
		} else {
			return true;
		}
	}
}



function inputTestIsNumber(input)
{
	var name = input.name;
	var value = input.value;
	var placeholder = input.placeholder;

	if (isNaN(parseInt(value, 10))) {
		message = 'Le format du champ "' + placeholder + '" est incorrecte.';
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	}
}



function inputTestIsEmail(input)
{
	var name = input.name;
	var value = input.value;
	var placeholder = input.placeholder;
	var mailformat = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;

	if(!value.match(mailformat))
	{
		message = 'Le format du champ "' + placeholder + '" est incorrecte.';
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	}
}



function inputTestIsSelect(select)
{	console.log(select.value);
	var name = select.name;
	if (select.value == 0) {
		message = 'Veuillez sélectionner un rôle.';
		error(select, true);

		changeClassAndMessage(name, message, true);
		return false;
	}
}


function inputTestSize(input)
{
	var name = input.name;
	var value = input.value;
	var sizeText = input.value.length;
	var min = input.minLength;
	var max = input.maxLength;
	var placeholder = input.placeholder;

	if (sizeText < min) {
		message = 'Le champ "' + placeholder + '" est trop court.';
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	} else if (sizeText > max) { 
		message = 'Le champ "' + placeholder + '" est trop long.';
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	} else {
		error(input, false);
		changeClassAndMessage(name, '', false);
		return true;
	}
}

function error(champ, erreur)
{
	if(erreur) {
		champ.style.backgroundColor = '#FF3F33';
	} else {
		champ.style.backgroundColor = '';
	}
}


function changeClassAndMessage(sName, sMessage, result)
{
	var para = '';
	var index = 0;
	console.log("name => " + sName);
	console.log("message => " + sMessage);
	console.log("result => " + result);


  	if (result) {
 		para = document.getElementsByClassName('hidden');
  		// Récupère l'index de l'élément p pointé
  		index = getParaIndex(para, sName);

 		if (para[index] == null) {
 			para = document.getElementsByClassName('display');
 			index = getParaIndex(para, sName);
 			para[index].innerHTML = '';
 		}
		var newContent = document.createTextNode(sMessage);
	 	// et lui donne un peu de contenu
		para[index].appendChild(newContent);
  		para[index].className = 'display';
  	} else {
 		para = document.getElementsByClassName('display');
 		index = getParaIndex(para, sName);

 		if (para[index] == null) {
 			para = document.getElementsByClassName('hidden');
 			index = getParaIndex(para, sName);
 			para[index].innerHTML = '';
 		}
		para[index].innerHTML = '';
  		para[index].className = 'hidden';  	
  	}
}


function getParaIndex(aElements, sName)
{
	var c = aElements.length;
	var index = '';

	for (var i = 0 ; i < c ; i++) {
		if (aElements[i].getAttribute('name') == sName) {
			index = i;
		}
	}
	return index;

}


function verifAllForm()
{
	var input = document.getElementsByClassName('add-user-input');
	var count = input.length;
	var result = '';
	
	for (var i = 0 ; i < count ; ) {
		var sizeText = input[i].value.length;
		var name = input[i].name;
		var min = input[i].minLength;
		var max = input[i].maxLength;

		if (name == 'status') {
			if (inputTestIsSelect(input[i]) === false) {
				return false;
			}
		}

		if (sizeText != 0) {
			if (name == 'phone' || name == 'cp') {
				if (inputTestIsNumber(input[i]) === false) {
					return false;
				}
			}
			if (name == 'email') {
				if (inputTestIsEmail(input[i]) === false) {
					return false;
				}
			}
	
			if (inputTestSize(input[i], min, max) === false) {
				return false;
			} else {
				result = true;
				i++;
			}
		}
	}
	return true;

}



function getCurrentDate()
{
	

	alert(text);
}