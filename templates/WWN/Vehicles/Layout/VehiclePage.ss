<section class="wrapper">
    <div class="inner">
        <%-- Breadcrumbs --%>
        <% include BreadCrumbs %>
        <hr>

        <% if $Headline %><h1>$Headline.RAW</h1><% end_if %>
        <br>
        <% if $Lead %><p>$Lead.RAW</p><% end_if %>
        <% if $Content %>
            $Content
        <% end_if %>

        <% if $PaginatedVehicles %>
            <div class="columns">
                <% loop $PaginatedVehicles %>
                    <div class="column">
                        <a href="$Top.Link$URLSegment/">
                            <% if $VehicleImages %>
                                <% loop $VehicleImages %>
                                    <% if $Cover && $Image %>
                                        <img class="margin-top-7" width="400" title="$Title"
                                             src="$Image.URL">
                                    <% end_if %>
                                <% end_loop %>
                            <% end_if %>
                        </a>
                        <div>
                            <a href="$Top.Link$URLSegment/">
                                $Name
                            </a>
                        </div>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
    </div>
</section>
