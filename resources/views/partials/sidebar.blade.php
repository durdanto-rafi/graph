<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- /.search form -->
        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu">
            <li class="header">MAIN OPTION</li>
            <li class="treeview {{ Request::is('answer') ? 'active' : '' }}">
                <a href="{{ route('answer.index') }}">
                    <i i class="fa fa-check-square-o"></i> <span>Answer</span>
                    <span class="pull-right-container">
                </span>
                </a>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>