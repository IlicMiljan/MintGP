<div class="container">
  <div class="col-md-4">
    <div class="page-info">
      <h3>Profil</h3>
      <img src="templates/img/icons/png/Pensils.png">
    </div>
  </div>
  <div class="col-md-8">
    <div class="panel panel-inverse">
      <div class="panel-heading">
        <h3 class="panel-title">Podešavanja: {$UserData.Username}</h3>
      </div>
      <div class="panel-body">
        <form action="" method="POST">
          <label style="margin-bottom: 0px;"><b>Ime:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesite svoje ime."></span></b></label>
          <input type="text" class="form-control" required="true" value="{$UserData.FirstName}" name="FirstName">
          <label style="margin-top: 5px; margin-bottom: 0px;"><b>Prezime:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesite svoje prezime."></span><b></label>
          <input type="text" class="form-control" required="true" value="{$UserData.LastName}" name="LastName">
          <label style="margin-top: 5px; margin-bottom: 0px;"><b>E-Mail Adresa:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesite svoju E-Mail Adresu. Adresa mora biti važeća!"></span><b></label>
          <input type="email" class="form-control" required="true" value="{$UserData.EmailAddress}" name="EmailAddress">
          <label style="margin-top: 5px; margin-bottom: 0px;"><b>Lozinka:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesite novu lozinku. Lozinka mora biti sigurna, odnosno, kompleksna!"></span><b></label>
          <input type="password" class="form-control" required="true" name="Password">
          <br/>
          <label style="margin-top: 5px; margin-bottom: 0px;"><b>PIN Verifikacija:* <span class="fui-question-circle" data-toggle="tooltip" title="Unesiti Vaš PIN kod kako biste sačuvali podešavanja!"></span><b></label>
          <input type="password" class="form-control" required="true" name="PIN">
          <button type="submit" class="btn btn-success pull-right" style="margin-top: 10px;"><span class="fui-check"></span> Sačuvaj Izmene</button>
        </form>
      </div>
    </div>
  </div>
</div>
