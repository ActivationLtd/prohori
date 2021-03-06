<ul class="sidebar-menu">
    @if(user())
        @if(user()->isManagerUser())
            <li><a href="{{route("tasks.create")}}" class="bg-green"><i class="fa fa-plus"></i><span>{{Lang::get('messages.Create-New-Task')}}</span></a>
            </li>
        @endif
        <li><a href="{{route("home")}}"><i
                        class="fa fa-desktop"></i><span>{{Lang::get('messages.Dashboard')}}</span></a></li>


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
            {{--<li class="header">LABELS</li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-red"></i> <span>Important</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-yellow"></i> <span>Warning</span></a></li>--}}
            {{--<li><a href="#"><i class="fa fa-circle-o text-aqua"></i> <span>Information</span></a></li>--}}
        @else
            {{--if user is manager--}}
            @if(user()->isManagerUser())
                <?php
                $module_names = [
                    'tasks',
                    'users',
                    //'clients',
                    'uploads',
                    'messages',
                ];
                ?>
                @foreach($module_names as $name)
                    <?php
                    /** @var \App\Module $module */
                    $module = \App\Module::where('name', $name)->remember(cacheTime('long'))->first()?>
                    <li><a href="{{route("{$module->name}.index")}}"><i
                                    class="{{$module->icon_css}}"></i>{{Lang::get('messages.'.$module->title)}}</a>
                    </li>
                @endforeach
            @endif
            @if(user()->isClientUser())
                <?php
                $module_names = [
                    'users',
                    'userlocations',
                    'clients',
                    'clientlocations',

                ];
                ?>
                @foreach($module_names as $name)
                    <?php
                    /** @var \App\Module $module */
                    $module = \App\Module::where('name', $name)->remember(cacheTime('long'))->first()?>
                    <li><a href="{{route("{$module->name}.index")}}"><i
                                    class="{{$module->icon_css}}"></i>{{Lang::get('messages.'.$module->title)}}</a>
                    </li>
                @endforeach
            @endif

        @endif
    @endif
</ul>



