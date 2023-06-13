<footer class="main-footer fixed-bottom">
    {{-- <div class="float-right d-none d-sm-block">
        <b id="footerTimer"></b>
    </div>
    <strong>Barangay Management System</strong>&nbsp;<small>Ver. 1.0</small> --}}

    <div class="d-md-flex justify-content-between">
        <span><strong>iShare System</strong>&nbsp;version 1.0</span>
        <span class="d-md-block d-none" id="footerTimer"></span>
    </div>
</footer>

<script type="text/javascript">
	setInterval( () => {
		var now = new Date();
		$("#footerTimer").text(now.toLocaleString('en-US', { timeZone: 'Asia/Manila' }));
	}, 1000);
</script>