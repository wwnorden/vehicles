<section>
    <%-- Breadcrumbs --%>
    <% include BreadCrumbs %>
    <hr>
    <div class="vehicles">
        <header class="main">
            <% if $Headline %><h1 id="vehicle-$ID">$Vehicle.Name.RAW</h1><% end_if %>
        </header>

        <div class="row">
            <div class="col-6 col-12-medium">
                <div class="table-wrapper">
                    <table>
                        <thead>
                        <tr>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_PagingName', 'PagingName') %></strong></td>
                            <td>$Vehicle.PagingName</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_Manufacturer', 'Manufacturer') %></strong></td>
                            <td>$Vehicle.Manufacturer</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_Model', 'Model') %></strong></td>
                            <td>$Vehicle.Model</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_Power', 'Power') %></strong></td>
                            <td>$Vehicle.Power</td>
                        </tr>
                        <tr>
                            <td>
                                <strong><% _t('WWN\Vehicles\Vehicle.db_ConstructionYear', 'ConstructionYear') %></strong>
                            </td>
                            <td>$Vehicle.ConstructionYear</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_Weight', 'Weight') %></strong></td>
                            <td>$Vehicle.Weight</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_Consolidation', 'Consolidation') %></strong></td>
                            <td>$Vehicle.Consolidation</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_Crew', 'Crew') %></strong></td>
                            <td>$Vehicle.Crew</td>
                        </tr>
                        <tr>
                            <td><strong><% _t('WWN\Vehicles\Vehicle.db_PeriodOfService', 'PeriodOfService') %></strong>
                            </td>
                            <td>$Vehicle.PeriodOfService</td>
                        </tr>
                            <% if $Vehicle.Successor %>
                                <tr>
                                    <td><strong><% _t('WWN\Vehicles\Vehicle.has_one_Successor', 'Successor') %></strong>
                                    </td>
                                    <td>
                                        <a href="$VehiclePagePath()/$Vehicle.Successor.URLSegment/" title="$Vehicle.Successor.Name">
                                            $Vehicle.Successor.Name
                                        </a>
                                    </td>
                                </tr>
                            <% else_if $Vehicle.Predecessor %>
                                <tr>
                                    <td>
                                        <strong><% _t('WWN\Vehicles\Vehicle.belongs_to_Predecessor', 'Predecessor') %></strong>
                                    </td>
                                    <td>
                                        <a href="$VehicleArchivePagePath()/$Vehicle.Predecessor.URLSegment/" title="$Vehicle.Predecessor.Name">
                                            $Vehicle.Predecessor.Name
                                        </a>
                                    </td>
                                </tr>
                            <% end_if %>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            <div class="col-6 col-12-medium">
                <% if $Vehicle.VehicleImages %>
                    <% loop $Vehicle.VehicleImages %>
                        <a href="$Image.URL">
                            <% if $Cover && $Image %>
                                <img title="$Title"
                                     src="$Image.URL">
                            <% end_if %>
                        </a>
                    <% end_loop %>
                <% end_if %>
            </div>
        </div>
        <p>$Vehicle.Content</p>
    </div>
</section>
