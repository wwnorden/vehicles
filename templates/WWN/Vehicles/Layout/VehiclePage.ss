<section>
    <%-- Breadcrumbs --%>
    <% include BreadCrumbs %>
    <hr>
    <div class="vehicles">
        <header class="main">
            <% if $Headline %><h1>$Headline.RAW</h1><% end_if %>
        </header>
        <% if $Lead %><p>$Lead.RAW</p><% end_if %>
        <% if $Content %>
            $Content
        <% end_if %>

        <% if $PaginatedVehicles %>
            <div class="row">
                <% loop $PaginatedVehicles %>
                    <div class="col-4 col-12-small">
                        <a href="$Top.Link$URLSegment/">
                            <% if $VehicleImages %>
                                <% loop $VehicleImages %>
                                    <% if $Cover && $Image %>
                                        <img title="$Title" src="$Image.URL">
                                    <% end_if %>
                                <% end_loop %>
                            <% end_if %>
                        </a>
                        <p class="tac">
                            <a class="button" href="$Top.Link$URLSegment/">
                                $Name | $PagingName
                            </a>
                        </p>
                    </div>
                <% end_loop %>
            </div>
        <% end_if %>
    </div>
</section>
