@if(config('admin.templation.footer.enable'))
<div class="footerbar">
    <footer class="footer">
        <p class="mb-0">© {{ \Carbon\Carbon::now()->year }} {{config('app.name')}} - All Rights Reserved.</p>
    </footer>
</div>
@endif
