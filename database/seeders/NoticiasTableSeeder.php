<?php

namespace Database\Seeders;

use App\Models\noticias;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoticiasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Datos de ejemplo para los jugadores
        $noticias =  [
            [
                'id' => '1',
                'titulo' => 'Y encima, Mbappé: su llegada silencia al Barcelona',
                'subtitulo' => 'No presenta capacidad económica para responder a un fichaje tan determinante.',
                'contenido' => 'El Barcelona vive momentos convulsos. El rendimiento deportivo del primer equipo no es el esperado pese a la inversión en la plantilla y la incertidumbre parece una constante en la entidad. A un escenario complejo se suma el éxito del eterno rival. El Real Madrid, campeón de LaLiga y la Supercopa, se ha clasificado para la final de la Champions League y, además, apuntala su proyecto con el soñado Kylian Mbappé para la campaña 2024-25. El francés, de hecho, anunció el viernes que deja el PSG.
                En los despachos del Camp Nou, históricamente, siempre han podido contrarrestar e incluso superar los fichajes tan mediáticos como desequilibrantes del club blanco. En esta ocasión, sin embargo, las arcas del club, dependientes de las palancas negociadas por Joan Laporta, y la situación general del mercado no facilitan la hipotética llegada de una incorporación que eclipse o suavice el aterrizaje de Mbappé en Barajas. 
                ',
                'publicado' => '2024-05-10 16:07:17',
                'imagen_path' => 'images\mbappe.png' // Ruta de la imagen

            ],
            [
                'id' => '2',
                'titulo' => 'La renovación de Cubarsí, a buen ritmo',
                'subtitulo' => 'Los contactos son positivos y las dos partes son optimistas',
                'contenido' => 'En el Barcelona hay pocos jugadores intransferibles, por las necesidades económicas de la entidad y por el bajón rendimiento de las últimas semanas, que ha provocado que el club culé apueste por una reestructuración, en la medida de sus posibilidades, de su plantilla. Pero uno de los intocables es un joven de 17 años que apenas lleva cinco meses en el primer equipo: Pau Cubarsí. No sólo no está en venta sino que la institución trabaja para retenerle, y la renovación va a buen ritmo.
                Los contactos que las dos partes están manteniendo están siendo muy positivos y todos son optimistas. "Avanzamos a buen ritmo", aseguran fuentes de la negociación a MARCA. Están seguros de que la firma se producirá en breve. Cubarsí, que concluye su contrato actual en junio de 2026, está cumpliendo su sueño de jugar en el primer equipo del Barcelona, Xavi le considera titular en el eje de la zaga y la institución catalana ya le ve como uno de sus símbolos. Todos quieren ampliar la relación que les une.
                Mbappé anuncia que dejará el PSG a final de temporada',
                'publicado' => '2024-05-10 16:07:17',
                'imagen_path' => 'images\cubarsi.png' // Ruta de la imagen

            ],
            [
                'id' => '3',
                'titulo' => 'Lo ha comunicado en sus redes sociales
                ',
                'subtitulo' => 'En un vídeo de cuatro minutos publicado en sus redes sociales.
                ',
                'contenido' => 'Quería hablar con ustedes. Siempre había dicho que iba a hablar con ustedes cuando fuera el momento adecuado. Quería decirles a todos que este es mi último año en el PSG. No voy a renovar. Terminaré mi aventura dentro de unas semanas. Jugaré mi último partido en el Parque de los Príncipes el domingo, empezaba el de Bondy.
                ',
                'publicado' => '2024-05-10 16:07:17',
                'imagen_path' => 'images\mbappepsg.png' // Ruta de la imagen

            ]
        ];

        // Crear jugadores en la base de datos
        foreach ($noticias as $noticia) {
            $nuevaNoticia = noticias::create([
                'id' => $noticia['id'],
                'titulo' => $noticia['titulo'],
                'subtitulo' => $noticia['subtitulo'],
                'contenido' => $noticia['contenido'],
                'publicado' => $noticia['publicado'],
            ]);

            // Agregar imagen a la colección de medios del jugador
            $nuevaNoticia->addMedia(public_path($noticia['imagen_path']))->preservingOriginal()->toMediaCollection('photo');
        }
    }
}
