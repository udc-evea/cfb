<html>
    <head></head>
    <body>
        <h2>¡Inscripción completa!</h2>
        <p>Enhorabuena, {{ $inscripcion->inscripto }}, has completado la inscripción al curso: <strong>{{ $inscripcion->curso->nombre }}.</strong></p>
        <p>En breve nos pondremos en contacto contigo.</p>
        <p>Atentamente,</p>
        <p>&nbsp;</p>
        <p>Centro de Formación Bimodal<br/>
           Universidad del Chubut
        </p>
    </body>
</html>