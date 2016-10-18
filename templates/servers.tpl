    <div class="container">
      <div class="col-md-4">
        <div class="page-info">
          <h3>Serveri</h3>
          <img src="templates/img/icons/png/Map.png">
        </div>
      </div>
      <div class="col-md-8">
        <div class="table-responsive">
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Ime Servera</th>
                <th>IP Adresa</th>
                <th>Slotovi</th>
                <th>Ističe</th>
                <th>Status</th>
              </tr>
            </thead>
            <tbody>
              {foreach item=Query from=$Servers}
              <tr>
                <td><a href="serversummary.php?ID={$Query.ID}">{$Query.Hostname}</a></td>
                <td>{$Query.ServerIP}</td>
                <td>{$Query.SlotNumber}</td>
                <td>{$Query.Expires}</td>
                {if $Query.Type eq '0'}
                <td><span class="text-warning"><b>Suspendovan</b><span></td>
                {elseif $Query.Type eq '1'}
                <td><span class="text-success"><b>Aktivan</b><span></td>
                {/if}
              </tr>
              {/foreach}
             </tbody>
           </table>
        </div>
      </div>
    </div>
