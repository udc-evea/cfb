<!DOCTYPE html>
<html lang="es-AR">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>
    </head>
<body>
@if(count($rows)>0)
    <table class="tablaExcel">        
        <tr>
            <td>
               First Name,Last Name,Email Address,Password,Secondary Email,Work Phone 1,Home Phone 1,Mobile Phone 1,Work address 1,Home address 1,Employee Id,Employee Type,Employee Title,Manager,Department,Cost Center 
            </td>
        </tr>
    <?php $i=1;?>
    @foreach($rows as $item)
        <tr>
           <td>
               <?php $firstName = $item->sanear_string($item->nombre); ?>
               <?php $lastName = $item->sanear_string($item->apellido); ?>
               {{ $firstName }},{{ $lastName }},{{ $item->email_institucional }},{{ $item->documento }},,,,,,,,,,,,
           </td>
        </tr>
        <?php $i++;?>
    @endforeach
    </table>
@else
    <table class="tablaExcel">
        <tr>
            <td>
                First Name,Last Name,Email Address,Password,Secondary Email,Work Phone 1,Home Phone 1,Mobile Phone 1,Work address 1,Home address 1,Employee Id,Employee Type,Employee Title,Manager,Department,Cost Center 
            </td>
        </tr>        
        <tr>
            <td></td>            
        </tr>
    </table>
@endif
</body>
</html>