<section class="wrapper">
    <div class="inner">
        <%-- Breadcrumbs --%>
        <% include BreadCrumbs %>
        <hr>

        <% if $Vehicle %>
            <h1 id="vehicle-$ID">$Vehicle.Name.RAW</h1>
            <dl>
                <dt><% _t('WWN\Vehicles\Vehicle.db_PagingName', 'PagingName') %></dt>
                <dd>$Vehicle.PagingName</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_Manufacturer', 'Manufacturer') %></dt>
                <dd>$Vehicle.Manufacturer</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_Model', 'Model') %></dt>
                <dd>$Vehicle.Model</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_Power', 'Power') %></dt>
                <dd>$Vehicle.Power</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_ConstructionYear', 'ConstructionYear') %></dt>
                <dd>$Vehicle.ConstructionYear</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_Weight', 'Weight') %></dt>
                <dd>$Vehicle.Weight</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_Consolidation', 'Consolidation') %></dt>
                <dd>$Vehicle.Consolidation</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_Crew', 'Crew') %></dt>
                <dd>$Vehicle.Crew</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.db_PeriodOfService', 'PeriodOfService') %></dt>
                <dd>$Vehicle.PeriodOfService</dd>

                <dt><% _t('WWN\Vehicles\Vehicle.has_one_Successor', 'Successor') %></dt>
                <dd>$Vehicle.Successor.Name</dd>
            </dl>

            <p>$Vehicle.Content</p>
            <% if $VehicleImages %>
                <p><strong><%_t('WWN\Vehicles\VehicleImage.PLURALNAME', 'Images')%></strong></p>
                <div id="$ID">
                    <% loop $VehicleImages %>
                        <a href="$Image.URL" alt="$Title" title="$Title">
                            <img src="$Image.URL"
                                 alt="$Title"
                                 title="$Title">
                        </a>
                    <% end_loop %>
                </div>
            <% end_if %>
            <br>
            <% if not $last %>
                <hr>
            <% end_if %>
        <% end_if %>
    </div>
</section>
