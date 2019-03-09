<ul class="sidebar-menu">
    @if(user())
        <li><a href="{{route("home")}}"><i class="fa fa-desktop"></i><span>Dashboard</span></a></li>

        @if(user()->isSuperUser())
            {{--<li class="header">MENU</li>--}}
            <?php
            /****************************************************************************************************
             * Renders the left menu of the application
             * $current_module_name and $breadcrumbs are passed to render function to expand the currently active
             * tree items. render function checks if $current_module_name is available in $breadcrumb.
             ****************************************************************************************************/
            $current_module_name = '';
            $breadcrumbs = [];
            if (isset($mod)) {
                $current_module_name = $mod->name;
                $breadcrumbs = breadcrumb($mod);
            }
            renderMenuTree(\App\Modulegroup::tree(), $current_module_name, $breadcrumbs);
            ?>
            <li><a href="{{route('invoices.report-bankline-export')}}"><i class="fa fa-download"></i>Bankline Export</a></li>
            {{--<li class="header">LABELS</li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
        @else
            @if(user()->ofPartner())
                <li><a href="{{route('partners.show', user()->partner_id)}}"><i class="fa fa-info-circle"></i>Brand
                        settings</a></li>
                <li><a href="{{route('partners.integration')}}"><i class="fa fa-code"></i>Integration</a></li>
                <?php
                $module_names = [
                    'recommendurls',
                    'purchases',
                    'beacons',
                    //'users',
                ];
                ?>

                @foreach($module_names as $name)
                    <?php
                    /** @var \App\Module $module */
                    $module = \App\Module::where('name', $name)->remember(cacheTime('long'))->first()?>
                    <li><a href="{{route("{$module->name}.index")}}"><i
                                    class="{{$module->icon_css}}"></i>{{$module->title}}</a></li>
                @endforeach

            @endif
        @endif
    @endif
</ul>