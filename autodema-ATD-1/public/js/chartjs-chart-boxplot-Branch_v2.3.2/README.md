# Chart.js Box and Violin Plot

[![datavisyn][datavisyn-image]][datavisyn-url] [![License: MIT][mit-image]][mit-url] [![NPM Package][npm-image]][npm-url] [![Github Actions][github-actions-image]][github-actions-url]

Chart.js module for charting box and violin plots. **Works only with Chart.js >= 2.8.0**

![Box Plot](https://user-images.githubusercontent.com/4129778/42724341-9a6ec554-8770-11e8-99b5-626e34dafdb3.png)
![Violin Plot](https://user-images.githubusercontent.com/4129778/42724342-9a8dbb58-8770-11e8-9a30-3e69d07d3b79.png)

## Install

```bash
npm install --save chart.js @sgratzl/chartjs-chart-boxplot
```

## Usage

see [Samples](https://github.com/sgratzl/chartjs-chart-box-and-violin-plot/tree/master/samples) on Github

and [![Open in CodePen][codepen]](https://codepen.io/sgratzl/pen/QxoLoY)

## Chart

four new types: `boxplot`, `horizontalBoxplot`, `violin`, and `horizontalViolin`.

## Config

```typescript
/**
 * Limit decimal digits by an optional config option
 **/
  tooltipDecimals?: number;
```

## Styling

The boxplot element is called `boxandwhiskers`. The basic options are from the `rectangle` element. The violin element is called `violin` also based on the `rectangle` element.

```typescript
interface IBaseStyling {
  /**
   * @default see rectangle
   * @scriptable
   * @indexable
   */
  backgroundColor: string;

  /**
   * @default see rectangle
   * @scriptable
   * @indexable
   */
  borderColor: string;

  /**
   * @default null takes the current borderColor
   * @scriptable
   * @indexable
   */
  medianColor: string;

  /**
   * @default 1
   * @scriptable
   * @indexable
   */
  borderWidth: number;

  /**
   * radius used to render outliers
   * @default 2
   * @scriptable
   * @indexable
   */
  outlierRadius: number;

  /**
   * @default see rectangle.backgroundColor
   * @scriptable
   * @indexable
   */
  outlierColor: string;

  /**
   * to fill color below the median line of the box
   * @default see rectangle.lowerColor
   * @scriptable
   * @indexable
   */
  lowerColor: string;

  /**
   * radius used to render items
   * @default 0 so disabled
   * @scriptable
   * @indexable
   */
  itemRadius: number;

  /**
   * item style used to render items
   * @default circle
   */
  itemStyle:
    | 'circle'
    | 'triangle'
    | 'rect'
    | 'rectRounded'
    | 'rectRot'
    | 'cross'
    | 'crossRot'
    | 'star'
    | 'line'
    | 'dash';

  /**
   * background color for items
   * @default see rectangle backgroundColor
   * @scriptable
   * @indexable
   */
  itemBackgroundColor: string;

  /**
   * border color for items
   * @default see rectangle backgroundColor
   * @scriptable
   * @indexable
   */
  itemBorderColor: string;

  /**
   * padding that is added around the bounding box when computing a mouse hit
   * @default 1
   * @scriptable
   * @indexable
   */
  hitPadding: number;

  /**
   * hit radius for hit test of outliers
   * @default 4
   * @scriptable
   * @indexable
   */
  outlierHitRadius: number;
}

interface IBoxPlotStyling extends IBaseStyling {
  // no extra styling options
}

interface IViolinStyling extends IBaseStyling {
  /**
   * number of sample points of the underlying KDE for creating the violin plot
   * @default 100
   */
  points: number;
}
```

In addition, two new scales were created `arrayLinear` and `arrayLogarithmic`. They were needed to adapt to the required data structure.

## Scale Options

Both `arrayLinear` and `arrayLogarithmic` support the two additional options to their regular counterparts:

```typescript
interface IArrayLinearScale {
  ticks: {
    /**
     * statistic measure that should be used for computing the minimal data limit
     * @default 'min'
     */
    minStats: 'min' | 'q1' | 'whiskerMin';

    /**
     * statistic measure that should be used for computing the maximal data limit
     * @default 'max'
     */
    maxStats: 'max' | 'q3' | 'whiskerMax';

    /**
     * from the R doc: this determines how far the plot ‘whiskers’ extend out from
     * the box. If coef is positive, the whiskers extend to the most extreme data
     * point which is no more than coef times the length of the box away from the
     * box. A value of zero causes the whiskers to extend to the data extremes
     * @default 1.5
     */
    coef: number;

    /**
     * the method to compute the quantiles.
     *
     * 7, 'quantiles': the type-7 method as used by R 'quantiles' method.
     * 'hinges' and 'fivenum': the method used by R 'boxplot.stats' method.
     * 'linear': the interpolation method 'linear' as used by 'numpy.percentile' function
     * 'lower': the interpolation method 'lower' as used by 'numpy.percentile' function
     * 'higher': the interpolation method 'higher' as used by 'numpy.percentile' function
     * 'nearest': the interpolation method 'nearest' as used by 'numpy.percentile' function
     * 'midpoint': the interpolation method 'midpoint' as used by 'numpy.percentile' function
     * @default 7
     */
    quantiles:
      | 7
      | 'quantiles'
      | 'hinges'
      | 'fivenum'
      | 'linear'
      | 'lower'
      | 'higher'
      | 'nearest'
      | 'midpoint'
      | ((sortedArr: number[]) => { min: number; q1: number; median: number; q3: number; max: number });
  };
}
```

## Data structure

Both types support that the data is given as an array of numbers `number[]`. The statistics will be automatically computed. In addition, specific summary data structures are supported:

```typescript
interface IBaseItem {
  min: number;
  median: number;
  max: number;
  /**
   * values of the raw items used for rendering jittered background points
   */
  items?: number[];
}

interface IBoxPlotItem extends IBaseItem {
  q1: number;
  q3: number;
  whiskerMin?: number;
  whiskerMax?: number;
  /**
   * list of box plot outlier values
   */
  outliers?: number[];
}

interface IKDESamplePoint {
  /**
   * sample value
   */
  v: number;
  /**
   * sample estimation
   */
  estimate: number;
}

interface IViolinItem extends IBaseItem {
  /**
   * samples of the underlying KDE
   */
  coords: IKDESamplePoint[];
}
```

**Note**: The statistics will be cached within the array. Thus, if you manipulate the array content without creating a new instance the changes won't be reflected in the stats. See also [![Open in CodePen][codepen]](https://codepen.io/sgratzl/pen/JxQVaZ?editors=0010) for a comparison.

## Tooltips

In order to simplify the customization of the tooltips, two additional tooltip callback methods are available. Internally the `label` callback will call the correspondig callback depending on the type.

```js
arr = {
  options: {
    tooltips: {
      callbacks: {
        /**
         * custom callback for boxplot tooltips
         * @param item see label callback
         * @param data see label callback
         * @param stats {IBoxPlotItem} the stats of the hovered element
         * @param hoveredOutlierIndex {number} the hovered outlier index or -1 if none
         * @return {string} see label callback
         */
        boxplotLabel: function (item, data, stats, hoveredOutlierIndex) {
          return 'Custom tooltip';
        },
        /**
         * custom callback for violin tooltips
         * @param item see label callback
         * @param data see label callback
         * @param stats {IViolinItem} the stats of the hovered element
         * @return {string} see label callback
         */
        violinLabel: function (item, data, stats) {
          return 'Custom tooltip';
        },
      },
    },
  },
};
```

## Building

```sh
npm install
npm run build
```

---

<div style="display:flex;align-items:center">
  <a href="https://www.datavisyn.io"><img src="https://user-images.githubusercontent.com/1711080/37700685-bcbb18c6-2cec-11e8-9b6f-f49c9ef6c167.png" align="left" width="50px" hspace="10" vspace="6"></a>
  Developed by&nbsp;<strong><a href="https://www.datavisyn.io">datavisyn</a></strong>.
</div>

[datavisyn-image]: https://img.shields.io/badge/datavisyn-io-black.svg
[datavisyn-url]: https://www.datavisyn.io
[mit-image]: https://img.shields.io/badge/License-MIT-yellow.svg
[mit-url]: https://opensource.org/licenses/MIT
[npm-image]: https://badge.fury.io/js/@sgratzl/chartjs-chart-boxplot.svg
[npm-url]: https://npmjs.org/package/@sgratzl/chartjs-chart-boxplot
[github-actions-image]: https://github.com/sgratzl/chartjs-chart-box-and-violin-plot/workflows/ci/badge.svg
[github-actions-url]: https://github.com/sgratzl/chartjs-chart-box-and-violin-plot/actions
[codepen]: https://img.shields.io/badge/CodePen-open-blue?logo=codepen
