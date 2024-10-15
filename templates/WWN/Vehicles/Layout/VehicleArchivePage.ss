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

        <% if $PaginatedArchivedVehicles(9) %>
            <div class="row">
                <% loop $PaginatedArchivedVehicles(9) %>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="$Top.Link$URLSegment/" class="image fit">
                            <% if $VehicleImages %>
                                <% loop $VehicleImages %>
                                    <% if $Cover && $Image %>
                                        <img width="400" title="$Title"
                                             src="$Image.URL">
                                    <% end_if %>
                                <% end_loop %>
                            <% end_if %>
                        </a>
                        <p class="tac">
                            <a class="button" title="$Name | $PagingName" href="$Top.Link$URLSegment/">
                                $Name.LimitWordCount(2) | $PagingName.LimitWordCount(1)
                            </a>
                        </p>
                    </div>
                <% end_loop %>
            </div>

            <% if $PaginatedArchivedVehicles(9).MoreThanOnePage %>
                <% if $PaginatedVehicles(9).NotFirstPage %>
                <a class="prev button button-color"
                   href="$PaginatedVehicles(9).PrevLink"><% _t('WWN\Vehicles\Vehicle.prev','Previous')%></a>
                <% end_if %>
                <% loop $PaginatedVehicles(9).PaginationSummary %>
                    <% if $CurrentBool %>
                        <p class="button disabled">$PageNum</p>
                    <% else %>
                        <% if $Link %>
                            <a href="$Link" class="button button-color">$PageNum</a>
                        <% else %>
                            ...
                        <% end_if %>
                    <% end_if %>
                <% end_loop %>
                <% if $PaginatedVehicles(9).NotLastPage %>
                <a class="next button button-color"
                   href="$PaginatedVehicles(9).NextLink"><% _t('WWN\Vehicles\Vehicle.next','Next')%></a>
                <% end_if %>
            <% end_if %>
        <% end_if %>
    </div>
</section>
