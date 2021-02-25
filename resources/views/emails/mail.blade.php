<!DOCTYPE html>
<html>
<head>
	<title>New Mail!</title>
</head>
<body>
<h4>New Mail!</h4>

<p>Subject: {{ $row['row']['subject'] }}</p>
<p><br/></p>
<p>Message: {{ $row['row']['body'] }}</p>
<p><br/></p>
@if(App\Models\Imageable::where('imageable_id', $row['row']['id'])->where('imageable_type', 'App\Models\Inbox')->count())
<p>Attachment: 
	<br/>
	@foreach(App\Models\Imageable::where('imageable_id', $row['row']['id'])->where('imageable_type', 'App\Models\Inbox')->get() as $img)
	<p>{{ $img->name }}</p>
	<p>
	    <a href="{{ App\Models\Imagable::getImagePath('inbox', $img->url) }}" target="_blank">Preview</a> 
	    &nbsp; . &nbsp; 
	    <a href="{{ App\Models\Imagable::getImagePath('inbox', $img->url) }}" download>Download</a>
	 </p>
	@endforeach
</p>
@endif
</body>
</html>