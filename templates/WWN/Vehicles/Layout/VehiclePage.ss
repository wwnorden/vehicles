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
                <% loop $PaginatedVehicles(10) %>
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
            <% if $PaginatedVehicles.MoreThanOnePage %>
                <% if $PaginatedVehicles.NotFirstPage %>
                    <a class="prev button"
                       href="$PaginatedVehicles.PrevLink"><% _t('WWN\Vehicles\Vehicle.prev','Previous')%></a>
                <% end_if %>
                <% loop $PaginatedVehicles.PaginationSummary %>
                    <% if $CurrentBool %>
                        <p class="button disabled">$PageNum</p>
                    <% else %>
                        <% if $Link %>
                            <a href="$Link" class="button">$PageNum</a>
                        <% else %>
                            ...
                        <% end_if %>
                    <% end_if %>
                <% end_loop %>
                <% if $PaginatedVehicles.NotLastPage %>
                    <a class="next button"
                       href="$PaginatedVehicles.NextLink"><% _t('WWN\Vehicles\Vehicle.next','Next')%></a>
                <% end_if %>
            <% end_if %>
        <% end_if %>
    </div>
</section>
