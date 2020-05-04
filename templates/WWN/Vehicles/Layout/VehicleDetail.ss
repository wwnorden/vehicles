<section class="wrapper">
    <div class="inner">
        <%-- Breadcrumbs --%>
        <% include Breadcrumbs %>
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
                        <a href="$Image.URL" alt="$Title" title="$Title" data-gallery="#blueimp-gallery-$Up.ID">
                            <img src="$Image.URL"
                                 class="img-rounded image-list"
                                 alt="$Title"
                                 title="$Title">
                        </a>
                    <% end_loop %>
                </div>
                <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
                    <div class="slides"></div>
                    <h3 class="title"></h3>
                    <a class="prev">‹</a>
                    <a class="next">›</a>
                    <a class="close">×</a>
                    <a class="play-pause"></a>
                    <ol class="indicator"></ol>
                </div>
            <% end_if %>
            <br>
            <% if not $last %>
                <hr>
            <% end_if %>
        <% end_if %>
    </div>
</section>
