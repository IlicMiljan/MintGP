    <div class="container">
      <div class="col-md-4">
        <div class="page-info">
          <h3>Tiket :: {$Ticket.ID}</h3>
          <img src="templates/img/icons/png/Book.png"><br/><br/>
          {if $Ticket.Status neq '2'}
          <a href="viewticket.php?Action=CloseTicket&TicketID={$Ticket.ID}" class="btn btn-danger"><span class="fui-cross"></span> Zatvori</a>
          <button type="button" class="btn btn-success" data-toggle="modal" data-target="#Answer"><span class="fui-plus"></span> Odgovori</button>
          {/if}
        </div>
      </div>
      <div class="col-md-8">
        <div class="panel panel-inverse">
          <div class="panel-heading">
            <h3 class="panel-title">Pitanje: {$Ticket.Title} <small class="pull-right date">{$Ticket.SubmitDate}</small></h3>
          </div>
          <div class="panel-body">
            {$Ticket.Content}
          </div>
        </div><br/>
        {foreach item=Query from=$Answers}
        <div class="panel panel-primary">
          <div class="panel-heading">
            <h3 class="panel-title">{$Query.Title} <small class="pull-right date">{$Query.SubmitDate}</small></h3>
          </div>
          <div class="panel-body">
            {$Query.Content}
          </div>
        </div>
        {/foreach}
      </div>
    </div>
    {if $Ticket.Status neq '2'}
    <div id="Answer" class="modal fade" role="dialog">
      <div class="modal-dialog modal-lg">
        <div class="modal-content">
          <div class="modal-header bg-inverse">
            <button type="button" class="close" style="color: #FFF" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Odgovori</h4>
          </div>
          <form action="" method="POST">
            <div class="modal-body">
              <input type="text" hidden="true" value="{$Ticket.ID}" name="TicketID">
              <label style="margin-top: 5px; margin-bottom: 0px;"><b>Odgovor:* <span class="fui-question-circle" data-toggle="tooltip" title="Minimalno 50 karaktera! Obrazložite Vaš problem što jasnije!"></span></b></label>
              <textarea class="form-control" required="true" minlength="50" rows="8" name="Content"></textarea>
            </div>
            <div class="modal-footer">
              <button type="submit" class="btn btn-success"><span class="fui-plus"></span> Pošalji</button>
            </div>
          </form>
        </div>
      </div>
    </div>
    {/if}
