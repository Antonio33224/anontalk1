<?php get_header(); ?>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <?php if (have_posts()) : ?>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php while (have_posts()) : the_post(); ?>
                <article class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold mb-4">
                        <a href="<?php the_permalink(); ?>" class="text-gray-900 hover:text-blue-500">
                            <?php the_title(); ?>
                        </a>
                    </h2>
                    <div class="prose prose-sm text-gray-600 mb-4">
                        <?php the_excerpt(); ?>
                    </div>
                    <a href="<?php the_permalink(); ?>" class="text-blue-500 hover:text-blue-600">
                        Ler mais
                    </a>
                </article>
            <?php endwhile; ?>
        </div>
        
        <div class="mt-8">
            <?php the_posts_pagination(); ?>
        </div>
    <?php else : ?>
        <div class="text-center py-12">
            <h2 class="text-2xl font-bold text-gray-900 mb-4">Nenhum conteúdo encontrado</h2>
            <p class="text-gray-600">Tente fazer uma nova busca ou volte para a página inicial.</p>
        </div>
    <?php endif; ?>
</main>

<?php get_footer(); ?>