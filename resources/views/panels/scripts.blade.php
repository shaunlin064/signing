{{-- Vendor Scripts --}}
<script src="{{ asset(mix('vendors/js/vendors.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/ui/prism.min.js')) }}"></script>
@yield('vendor-script')
<script src="{{ asset(mix('js/scripts/help/helper.js')).'?v='.time() }}"></script>
{{-- Theme Scripts --}}
<script src="{{ asset(mix('vendors/js/extensions/sweetalert2.all.min.js')) }}"></script>
<script src="{{ asset(mix('js/core/app-menu.js')) }}"></script>
<script src="{{ asset(mix('js/core/app.js')) }}"></script>
<script src="{{ asset(mix('js/app.js')).'?v='.time() }}"></script>
<script src="{{ asset(mix('js/scripts/components.js')) }}"></script>

@if($configData['blankPage'] == false)
<script src="{{ asset(mix('js/scripts/customizer.js')) }}"></script>
<script src="{{ asset(mix('js/scripts/footer.js')) }}"></script>
@endif

{{-- page script --}}
@yield('page-script')
{{-- page script --}}
