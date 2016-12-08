<p id="access-token"></p>
<script language="javascript">
 var url=document.URL;
 var hashidx=url.indexOf("#");
 var access_token = url.substring(hashidx+1);
 document.getElementById('access-token').innerHTML = access_token;
</script>
