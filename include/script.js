/** Liste des fonctions JavaScript pour les formulaires
	*	verifInputText(input) --------------> Fonction pour vérifier les valeurs des input du formulaire
	*	inputTestIsNumber(input) -----------> Fonction pour vérirfier si les valeurs saisies sont bien des chiffres
	*	inputTestIsEmail(input) ------------> Fonction pour vérirfier si les valeurs saisies sont bien au format mail
	*	verifPassPattern(input) ------------> Fonction pour vérirfier les mots de passes
	*	verifSamePass() --------------------> Fonction pour vérifier si les mots de passe sont égaux
	*	returnSpecialChar(nAscii) ----------> Code ASCII pour les chaînes de caractères
	*	inputTestSize(input) ----------> Fonction pour vérirfier l'élément select
	*	inputTestSize(input) ---------------> Fonction pour vérirfier la taille des valeurs saisies
	*	error(champ, erreur) ---------------> Fonction pour changer le background du champ si il y a une erreur
	*	changeClassAndMessage(sName, sMessage, result)-> Fonction qui renvoie les messages d'erreur en fonction de celles-ci
	*	getParaIndex(aElements, sName) -----> Fonction qui renvoie l'indes d'un élément
	*	verifAllForm() ---------------------> Fonction pour vérifier tout le formulaire quand le bouton valoider est pressé
	**/


// Fonction pour vérifier les valeurs des input du formulaire
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


// Fonction pour vérirfier si les valeurs saisies sont bien des chiffres
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


// Fonction pour vérirfier si les valeurs saisies sont bien au format mail
function inputTestIsEmail(input)
{
	var name = input.name;
	var value = input.value;
	var placeholder = input.placeholder;
	var mailFormat = /^([a-zA-Z0-9_\-\.]+)@([a-zA-Z0-9_\-\.]+)\.([a-zA-Z]{2,5})$/;

	if(!value.match(mailFormat))
	{
		message = 'Le format du champ "' + placeholder + '" est incorrecte.';
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	}
}

// Fonction pour vérirfier les mots de passes
function verifPassPattern(input)
{
	var value = input.value;
	var length = value.length;
	var lowerCase = 0;
	var upperCase = 0;
	var number = 0;
	var specialChar = 0;
	var passLength = 0;

	var blocks = new Array();

	for (var i = 0 ; i < 5 ; i++) {
		blocks[i] = document.getElementById('rule-' + i); 
		blocks[i].className = 'red';
	}

	if (length >= 12 && length <= 36) {
		passLength = 1;
		blocks[4].className = 'green';
	}

	for (var i = 0 ; i < length ; i++) {
		if (value.charCodeAt(i) >= 65 && value.charCodeAt(i) <= 90 && upperCase == 0) {
			upperCase = 1;
			blocks[0].className = 'green';
		}
		if (value.charCodeAt(i) >= 97 && value.charCodeAt(i) <= 122 && lowerCase == 0) {
			lowerCase = 1;
			blocks[1].className = 'green';
		}
		if (returnSpecialChar(value.charCodeAt(i)) === 1 && specialChar == 0) {
			specialChar = 1;
			blocks[2].className = 'green';			
		}
		if (!isNaN(value[i]) && number == 0) {
			number = 1;
			blocks[3].className = 'green';
		}
	}
}


// Fonction pour vérifier si les mots de passe sont égaux
function verifSamePass()
{

	var passwords = document.getElementsByClassName('btn-custom');
	var block = document.getElementById('same-pass'); 
	block.className = 'red';

	if ((passwords[1].value == passwords[2].value) && passwords[2].value.length > 0 && passwords[1].value.length > 0) {
		block.className = 'green';
		error(passwords[1], false);
		error(passwords[2], false);
		return true;
	} else {
		error(passwords[1], true);
		error(passwords[2], true);
		return false;
	}
}

// Code ASCII pour les chaînes de caractères
function returnSpecialChar(nAscii)
{
	if (nAscii == 33 || nAscii == 64 || (nAscii >= 35 && nAscii <= 38) || nAscii == 94 || nAscii == 42 || 
		nAscii == 95 || nAscii == 61 || nAscii == 43 || nAscii == 45) {
		return 1;
	} else {
		return 0;
	}
}

// Fonction pour vérirfier l'élément select'
function inputTestIsSelect(select)
{
	var name = select.name;
	if (select.value == 0) {
		message = 'Veuillez sélectionner un rôle.';
		error(select, true);
		changeClassAndMessage(name, message, true);
		return false;
	}
}

// Fonction pour vérirfier la taille des valeurs saisies
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

// Fonction pour changer le background du champ si il y a une erreur
function error(champ, erreur)
{
	if(erreur) {
		champ.style.backgroundColor = '#FF3F33';
	} else {
		champ.style.backgroundColor = '';
	}
}

// Fonction qui renvoie les messages d'erreur en fonction de celles-ci
function changeClassAndMessage(sName, sMessage, result)
{
	var para = '';
	var index = 0;

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

// Fonction qui renvoie l'indes d'un élément
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

// Fonction pour vérifier tout le formulaire quand le bouton valoider est pressé
function verifAllForm()
{
	var input = document.getElementsByClassName('btn-custom');
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



