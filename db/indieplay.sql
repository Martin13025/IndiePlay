CREATE DATABASE IF NOT EXISTS indieplay;
USE indieplay;

DROP TABLE IF EXISTS juegos;

CREATE TABLE juegos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(100),
    descripcion TEXT,
    precio DECIMAL(6,2),
    imagen VARCHAR(255)
);

INSERT INTO juegos (nombre, descripcion, precio, imagen) VALUES
('The Witcher 3: Wild Hunt', 'Interpretas a Geralt de Rivia, un cazador de monstruos en un mundo oscuro lleno de magia antigua, intrigas políticas y decisiones morales. Un mundo abierto inmenso, misiones profundas y personajes memorables hacen de esta RPG una obra maestra.', 19.99, 'assets/img/witcher3.jpg'),

('Red Dead Redemption 2', 'Una aventura épica en el Viejo Oeste. Juegas como Arthur Morgan, un forajido que lucha por sobrevivir mientras se desmorona su banda. Gráficos impresionantes, narrativa emocional y una experiencia inmersiva.', 24.99, 'assets/img/rdr2.jpg'),

('Cyberpunk 2077', 'Un RPG de acción en Night City, una metrópolis futurista. Como V, personalizas tu cuerpo con ciberimplantes, tomas decisiones que afectan la historia y descubres los secretos de un mundo tecnológico y caótico.', 29.99, 'assets/img/cyberpunk2077.jpg'),

('Stardew Valley', 'Simulador de granja con elementos de rol. Tras heredar una granja, puedes cultivar, criar animales, relacionarte con los aldeanos y vivir una vida tranquila y satisfactoria en el campo.', 9.99, 'assets/img/stardew.jpg'),

('Hades', 'Un roguelike ambientado en la mitología griega. Juegas como Zagreus, hijo de Hades, que intenta escapar del Inframundo. Cada intento es distinto gracias a combates rápidos y habilidades aleatorias.', 14.99, 'assets/img/hades.jpg'),

('Hollow Knight', 'Explora un reino subterráneo lleno de misterios y enemigos desafiantes. Un metroidvania atmosférico con una estética cuidada y una historia profunda contada a través del entorno.', 11.99, 'assets/img/hollow_knight.jpg'),

('Celeste', 'Un juego de plataformas desafiante con una historia emotiva sobre el crecimiento personal. Acompaña a Madeline en su ascenso a la montaña mientras enfrenta sus miedos internos.', 7.99, 'assets/img/celeste.jpg'),

('DOOM Eternal', 'Un shooter en primera persona brutal y rápido. Sos el Doom Slayer, enfrentándote a hordas demoníacas con un arsenal devastador. Combate intenso, fluido y lleno de adrenalina.', 19.99, 'assets/img/doom_eternal.jpg'),

('Terraria', 'Juego de aventuras y construcción en 2D. Cava, explora, construye y lucha en un mundo lleno de posibilidades. Miles de objetos, enemigos y jefes por descubrir.', 5.99, 'assets/img/terraria.jpg'),

('Dead Cells', 'Un roguelike de acción en 2D con combate preciso y niveles generados proceduralmente. Combina exploración con combates intensos y mejoras constantes.', 10.99, 'assets/img/dead_cells.jpg'),

('Among Us', 'Juego multijugador social. Tripulantes y impostores en una nave espacial: completa tareas o sabotea y elimina a los demás sin ser descubierto. Perfecto para jugar con amigos.', 3.99, 'assets/img/among_us.jpg'),

('Subnautica', 'Una aventura submarina en un planeta alienígena. Construye tu base, recolecta recursos y sobrevive mientras descubres los secretos del océano profundo.', 12.99, 'assets/img/subnautica.jpg'),

('Ori and the Blind Forest', 'Un juego de plataformas con una historia emotiva y un arte visual impresionante. Sigue a Ori en su viaje a través de un bosque mágico lleno de desafíos y maravillas.', 9.99, 'assets/img/ori.jpg'),

('It Takes Two', 'Una aventura cooperativa para dos jugadores. Dos padres convertidos en muñecos deben trabajar juntos para superar obstáculos y salvar su relación.', 15.99, 'assets/img/it_takes_two.jpg'),

('Portal 2', 'Un juego de puzzles en primera persona donde usas portales para resolver desafíos. Humor inteligente, narrativa envolvente y diseño de niveles brillante.', 7.49, 'assets/img/portal2.jpg');

CREATE TABLE IF NOT EXISTS configuracion (
    id INT PRIMARY KEY,
    logo VARCHAR(255) NOT NULL
);

INSERT INTO configuracion (id, logo) VALUES
(1, 'assets/img/logo.png');
