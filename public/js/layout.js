function fadeOut() {
  var fadeTarget = document.getElementById('alert');
  var fadeEffect = setInterval(function ()
  {
      if (!document.getElementById('alert')) {
        return;
      }
      if (!fadeTarget.style.opacity) {
          fadeTarget.style.opacity = 1;
      }
      else if (fadeTarget.style.opacity > 0) {
          fadeTarget.style.opacity -= 0.1;
      } else {
          clearInterval(fadeEffect);
      }
      if (fadeTarget.style.opacity <= 0) {
        document.getElementById('alert').style.display='none';
        clearInterval(fadeEffect);
        return;
      }

  }, 200);
}


function submitForm() {
  var licensePlate = document.getElementById('license_plate').value;
  var url = window.location.protocol + '//' + window.location.hostname + ':' + window.location.port + '/vehicules/recherche/';
  if (licensePlate != "") {
    url += licensePlate;
  }
  else {
    url+= 'tous';
  }
  document.getElementById('formSearch').action = url;
  var inputs = document.getElementsByTagName('input');
  while (inputs.length) inputs[0].parentNode.removeChild(inputs[0]);
  document.getElementById('formSearch').submit();
}


function transFormProfile() {
  var showProfile = document.getElementById('showProfile').style.display;
  if (showProfile === "block") {
    document.getElementById('showProfile').style.display = 'none';
    document.getElementById('formProfile').style.display = 'block';
  } else {
    document.getElementById('formProfile').style.display = 'none';
    document.getElementById('showProfile').style.display = 'block';
  }
}

function transForm(idShow, idForm) {
  var show = document.getElementById(idShow).style.display;
  if (show === "block") {
    document.getElementById(idShow).style.display = 'none';
    document.getElementById(idForm).style.display = 'block';
  } else {
    document.getElementById(idForm).style.display = 'none';
    document.getElementById(idShow).style.display = 'block';
  }
}


var countRepair = Number(document.getElementById('counter').value);
function addRepair() {
  countRepair += 1;
  document.getElementById('counter').value = countRepair;
  var select = document.getElementById('selectRepair').innerHTML;
  var newdiv = document.createElement('div');
  newdiv.id = "repair"+countRepair;
  newdiv.innerHTML = '<div class="row"> <div class="col-lg-4 col-form-label card-text text-center text-white">Réparation</div> <div class="col-lg-8"> <select class="form-control" name="repair'+countRepair+'" placeholder="--Choisissez une réparation--">'+select+'</select> </div> </div> <div class="row"> <div class="col-lg-4 col-form-label card-text text-center text-white">Main d\'oeuvre TTC €</div> <div class="col-lg-8"> <input type="number" class="form-control" name="laborCost'+countRepair+'" placeholder="45.00"> </div> </div> <div class="row smallMargin"> <div class="col-lg-4 col-form-label card-text text-center text-white">Pièces TTC €</div> <div class="col-lg-8"> <input type="number" class="form-control" name="technicalCost'+countRepair+'" placeholder="94.56"> </div> </div> <div class="smallMargin"> </div>';
  document.getElementById('allRepairs').appendChild(newdiv);
  return;
}
