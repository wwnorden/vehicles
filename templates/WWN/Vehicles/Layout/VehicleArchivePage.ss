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

        <% if $PaginatedArchivedVehicles %>
            <div class="columns">
                <% loop $PaginatedArchivedVehicles %>
                    <div class="column">
                        <a href="$Top.Link$URLSegment/">
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
        <% end_if %>
    </div>
</section>
