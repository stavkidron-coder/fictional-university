<?php get_header(); ?> <!-- Imports the Header component -->

<div class="page-banner">
    <div
        class="page-banner__bg-image"
        style="background-image: url(<?php echo get_theme_file_uri('/images/library-hero.jpg'); ?>);"> <!-- Imports image from the images folder -->
    </div>
        <div class="page-banner__content container t-center c-white">
            <h1 class="headline headline--large">Welcome!</h1>
            <h2 class="headline headline--medium">We think you&rsquo;ll like it here.</h2>
            <h3 class="headline headline--small">Why don&rsquo;t you check out the <strong>major</strong> you&rsquo;re interested in?</h3>
            <a href="#" class="btn btn--large btn--blue">Find Your Major</a>
        </div>
    </div>

    <div class="full-width-split group">
        <div class="full-width-split__one">
            <div class="full-width-split__inner">
                <h2 class="headline headline--small-plus t-center">Upcoming Events</h2>

                <?php
                    //Custom Queries
                    $today = date('Ymd'); // Creates a variable that contains the current date
                    $homepageEvents = new WP_Query(array( // Creates a new variable that holds all custom queries to WordPress
                        'posts_per_page' => 2, // Determines how many posts to query. If set to -1, shows all posts
                        'post_type' => 'event', // Determines what kind of post to query
                        'meta_key' => 'event_date', // Targets the custom field of 'event_date'
                        'orderby' => 'meta_value_num', // Determines what value to order by (In this case, the numeric value of meta_key)
                        'order' => 'ASC', // Determines how to order the values
                        'meta_query' => array( // only displays specific items from custom fields
                            array( // each custom field needs an array of its own
                                // Only show the event if...
                                'key' => 'event_date', // ... the custom field...
                                'compare' => '>=', // ... Is greater than or equal to...
                                'value' => $today, // ... The current date
                                'type' => 'numeric' // Tells WordPress what kind of values it should look for
                            )
                        )
                    ));

                    while ($homepageEvents->have_posts()) { //While there are posts -->
                        $homepageEvents->the_post(); ?> <!-- digs into the custom queries and gets the information for every post -->

                        <div class="event-summary">
                            <a class="event-summary__date t-center" href="#">
                                <span class="event-summary__month">
                                    <?php
                                        $eventDate = new DateTime(get_field('event_date')); //Creates a new variable that stores the date from the custom field 'event_date' ('get_date' is associated with the 'Advanced Custom Fields' Plugin).
                                         echo $eventDate->format('M'); //digs into the eventDate variable and Displays the month (3 letter abbreviation)
                                    ?>
                                </span>
                                <span class="event-summary__day">
                                    <?php
                                        echo $eventDate->format('d'); //digs into the eventDate variable and Displays the day (numeric)
                                    ?>
                                </span>
                            </a>
                            <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h5>
                                <p>
                                    <?php
                                        if (has_excerpt()) { //If there are excerpts -->
                                            echo get_the_excerpt(); //Display the excerpt
                                        } else {
                                            echo wp_trim_words(get_the_content(), 18); //Otherwise, Display the post's content and limit it to the first 18 characters
                                        }
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="nu gray">Learn more</a> <!-- Links to the specific post's page with permalink -->
                                </p>
                            </div>
                        </div>


                    <?php
                    }
                ?>

                <p class="t-center no-margin">
                    <a
                        href="<?php echo get_post_type_archive_link('event'); ?>" class="btn btn--blue"> <!-- gets the link to the archive of the post type and sets it as the href value -->
                            View All Events
                    </a>
                </p>
            </div>
        </div>

        <div class="full-width-split__two">
            <div class="full-width-split__inner">
                <h2 class="headline headline--small-plus t-center">From Our Blogs</h2>
                
                <?php
                    $homepagePosts = new WP_Query(array( // Creates a new variable containing a custom query
                        'posts_per_page' => 2 // Limits posts displayed onto the page to 2
                    ));

                    while($homepagePosts->have_posts()){ // While there are posts -->
                        $homepagePosts->the_post(); ?> <!-- Creates a variable that contains the info for each individual post -->

                        <div class="event-summary">
                            <a class="event-summary__date event-summary__date--beige t-center" href="<?php the_permalink(); ?>"> <!-- Creates a link to the specific post -->
                                <span class="event-summary__month"><?php the_time('M') ?></span> <!-- Displays the month (3 letter abbreviation) that the post was created -->
                                <span class="event-summary__day"><?php the_time('d') ?></span> <!-- Displays the day (numeric) that the post was created -->
                            </a>
                            <div class="event-summary__content">
                                <h5 class="event-summary__title headline headline--tiny">
                                    <a href="<?php the_permalink(); ?>"> <!-- Sets the link destination to the post's page -->
                                        <?php the_title(); ?> <!-- displays the title of the post -->
                                    </a>
                                </h5>
                                <p>
                                    <?php
                                        if (has_excerpt()) { // If there is an excerpt...
                                            echo get_the_excerpt(); // Display the excerpt
                                        } else { // Otherwise...
                                            echo wp_trim_words(get_the_content(), 18); // Display the post's content and limit it to the first 18 characters
                                        }
                                    ?>
                                    <a href="<?php the_permalink(); ?>" class="nu gray">Read more</a> <!-- Sets the link to the post's page -->
                                </p>
                            </div>
                        </div>

                    <?php } wp_reset_postdata(); // *IMPORTANT* Resets the post data to start fresh on next loop run-through
                ?>

                <p class="t-center no-margin">
                    <a href="<?php echo site_url('/blog'); ?>" class="btn btn--yellow"> <!-- Navigates to the /blog address to view all blog posts -->
                        View All Blog Posts
                    </a>
                </p>

            </div>
        </div>
    </div>

    <div class="hero-slider">
        <div data-glide-el="track" class="glide__track">
            <div class="glide__slides">
                <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bus.jpg') ?>);">
                    <div class="hero-slider__interior container">
                        <div class="hero-slider__overlay">
                            <h2 class="headline headline--medium t-center">Free Transportation</h2>
                            <p class="t-center">All students have free unlimited bus fare.</p>
                            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                        </div>
                    </div>
                </div>

                <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/apples.jpg') ?>);">
                    <div class="hero-slider__interior container">
                        <div class="hero-slider__overlay">
                            <h2 class="headline headline--medium t-center">An Apple a Day</h2>
                            <p class="t-center">Our dentistry program recommends eating apples.</p>
                            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                        </div>
                    </div>
                </div>

                <div class="hero-slider__slide" style="background-image: url(<?php echo get_theme_file_uri('/images/bread.jpg') ?>);">
                    <div class="hero-slider__interior container">
                        <div class="hero-slider__overlay">
                            <h2 class="headline headline--medium t-center">Free Food</h2>
                            <p class="t-center">Fictional University offers lunch plans for those in need.</p>
                            <p class="t-center no-margin"><a href="#" class="btn btn--blue">Learn more</a></p>
                        </div>
                    </div>
                </div>

            </div>

            <div
                class="slider__bullets glide__bullets"
                data-glide-el="controls[nav]">
            </div>

        </div>
    </div>

<?php get_footer(); ?> <!-- Imports the footer component -->