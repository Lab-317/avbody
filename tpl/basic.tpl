<html>
<head>

</head>
<body>
<table>
<tr>
       	<td>學號</td>
	<td>姓名</td>
	<td>手機</td>
    	<td>e-mail</td>

</tr>
{foreach from=$info item=student}
    <tr>
       	<td>{$student.stdNum}</td>
	<td>{$student.name}</td>
	<td>{$student.phone}</td>
    	<td>{$student.email}</td>
    </tr>

{/foreach}
</table>

</body>
</html>
