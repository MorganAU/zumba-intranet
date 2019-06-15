function verifInputText(champ, nMin, nMax)
{
	var sizeText = champ.value.length;
	var name = champ.name;

	if (sizeText != 0) {
		if (name == 'phone' || name == 'cp') {
			if (inputTestIsNumber(champ) === false) {
				return false;
			}
		}

		if (name == 'email') {
			if (inputTestIsEmail(champ) === false) {
				return false;
			}
		}

		if (inputTestSize(champ, nMin, nMax) === false) {
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
	var placeholder = input["placeholder"];
	var message = '';

	if (isNaN(parseInt(value, 10))) {
		message = 'Le format du champ "' + placeholder + '" est incorrecte.'
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	}
}

function inputTestIsEmail(input)
{
	var name = input.name;
	var value = input.value;
	var placeholder = input["placeholder"];
	var message = '';
	var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
	if(!value.match(mailformat))
	{
		message = 'Le format du champ "' + placeholder + '" est incorrecte.'
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	}
}

function inputTestSize(input, min, max)
{
	var name = input.name;
	var value = input.value;
	var sizeText = input.value.length;
	var placeholder = input["placeholder"];
	var message = '';

	if (sizeText < min) {
		message += 'Le champ "' + placeholder + '" est trop court.';
		error(input, true);
		changeClassAndMessage(name, message, true);
		return false;
	} else if (sizeText > max) { 
		message += 'Le champ "' + placeholder + '" est trop long.';
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
		champ.style.backgroundColor = "#FF3F33";
	} else {
		champ.style.backgroundColor = "";
	}
}


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
 			para[index].innerHTML = "";
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
 			para[index].innerHTML = "";
 		}
		para[index].innerHTML = "";
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
	var input = document.getElementsByClassName("add-user-input");
	var count = input.length;
	var aMin = [6, 6, 6, 5, 4, 6, 10];
	var aMax = [18, 18, 248, 5, 75, 75, 10];
	var result = '';
	
	for (var i = 0 ; i < count ; ) {
		var sizeText = input[i].value.length;
		var name = input[i].name;
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
	
			if (inputTestSize(input[i], aMin[i], aMax[i]) === false) {
				return false;
			} else {
					console.log(true);
					console.log(i);
				result = true;
				i++;
			}
		}
	}

	return true;

}
