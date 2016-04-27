![image](https://www.drivdigital.no/wp-content/themes/drivdigital/library/images/logo.svg)

---

# Base Theme

This theme is stripped back and is designed with helpers. This theme will help you build a responsive website that scales exceptionally.

---

### How do I get it running?

This theme uses [Grunt](http://gruntjs.com/) for the assets, it compiles scss, minifies images and does some other neat little tricks.

To begin:

1. Go into the theme `cd driv-starter`
2. Install all NPM packages with `sudo npm install`
3. Once installed, run one of three `grunt` commanges

### Different runtimes:

1. `grunt` only compiles files
2. `grunt dev` runs browserSync for live reloading
3. `grunt slim` minifies the project

![image](http://g.recordit.co/StFt7GoLzB.gif)

---

### Mixins

We've written some basic mixing for grids and adaptive scaling.

#### Grid

For the grid, we use the mixing `span()`. It has four arguments:

- `How many columns the element is`
- `How many columns in total`
- `The gutter between these columns`
- `Is this the last element?`

Here's an example of how we use it:

    .main {
        // Covers 8 of 12 columns across
        @include span( 8, 12, 1rem );
    }

    .aside {
        // Four columns, last element in the grid
        @include span( 4, 12, 1rem, true )
    }

#### Media Queries

Things need to be simple when writing media queries, none of that nonse about `@media #{tablet}`. It tells us nothing about what it's doing other than there's a tablet involved.

To make this process easier, you can do your mediaqueries like so:

    @include wider-than ( tablet ){
        /* This is now content that will only show
        when we're wider than a tablet device */
    }

Obviously, you can do the opposite too

    @include not-wider-than ( tablet ){
        /* This is now content that will only show
        when we're not wider than a tablet device */
    }

To find more about your devices list, you can view them here: [Mediaqueries](https://github.com/drivdigital/driv-starter/blob/master/assets/scss/partials/mixins/_0_mediaqueries.scss)

#### Scaling elements

There's a mixing called `modular` which gives you the ability to define a scale for `font-size`. Allowing typography to be more fluid with your device.

Usage:

    h1 {
        @include modular( 4rem );
    }

This will output a few `mediaqueries` that define the font size in a scale, as you view the the on different sized devices, the font size will scale with it.

You can customise this by added an addition scale unit to the mixing:

    h1 {
        @include modular( 4rem, 1.05 );
    }

This will scale the 4rem by 1.05 per mediaquery: `( 4rem / 1.05 = 3.8rem)`.
This allows you to scale different elements to keep the flow of your type.

#### oh, there's more?

You can also use this specific elements:

    h1{
        @include modular-element( padding-bottom, 5rem );
    }

This will give you a `padding-bottom` on your `h1` that will scale with your devices.

From here, you can write other mixing that utilise these technique, allowing you to write variables that change the vertical rhythm of the page.

---

This theme is under constant development. If you find any issues with it, please [file an issue](https://github.com/drivdigital/driv-starter/issues)