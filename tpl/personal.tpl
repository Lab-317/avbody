<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>
<body>
<table>
<tr><td>學號：{$info.stdNum}</td><tr>
<tr><td>姓名：{$info.name}</td><tr>
</table>
<table>
<tr><td>工作態度</td><td>表達與溝通能力</td><td>規劃能力</td><td>團隊合作</td><td>領導力</td>
<td>學習能力</td><td>穩定度與抗壓性</td><td>創造力</td></tr>
<tr>
<td>{$stdScore.WorkAttitute*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.Present*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.Planning*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.TeamWorking*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.Leadership*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.Learning*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.StableAttr*10+60|string_format:"%.2f"}</td>
<td>{$stdScore.creative*10+60|string_format:"%.2f"}</td>
</tr>
</table>
<img src="http://chart.apis.google.com/chart?cht=r&chxt=x&chs=500x600&chd=t:{$stdScore.Planning*10+60},{$stdScore.Learning*10+60},{$stdScore.Present*10+60},{$stdScore.WorkAttitute*10+60},{$stdScore.TeamWorking*10+60},{$stdScore.creative*10+60},{$stdScore.Leadership*10+60},{$stdScore.StableAttr*10+60},{$stdScore.Planning*10+60}|60,60,60,60,60,60,60,60,60&chxl=0:|{$urlEncodeName.Planning}|{$urlEncodeName.Learning}|{$urlEncodeName.Present}|{$urlEncodeName.WorkAttitute}|{$urlEncodeName.TeamWorking}|{$urlEncodeName.Creative}|{$urlEncodeName.Leadership}|{$urlEncodeName.StableAttr}&chtt=就業力分析圖&chxs=0,0000dd,16|3,0000dd,12,1&chco=FF0000,FF9900&chm=D,C6D9FD,1,0,8|D,4D89F9,0,0,4&chdl=Average|Self&chco=C6D9FD,4D89F9&chdlp=b"/>
</body>
</html>
