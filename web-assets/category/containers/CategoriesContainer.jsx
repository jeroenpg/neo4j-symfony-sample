/**
 *         _             __        __ _
 *   /\/\ (_) ___ __ _  / _\ ___  / _| |___      ____ _ _ __ ___
 *  /    \| |/ __/ _` | \ \ / _ \| |_| __\ \ /\ / / _` | '__/ _ \
 * / /\/\ \ | (_| (_| | _\ \ (_) |  _| |_ \ V  V / (_| | | |  __/
 * \/    \/_|\___\__,_| \__/\___/|_|  \__| \_/\_/ \__,_|_|  \___|
 * ----------------------------------------------
 * Copyright (c) 2017, Mica Software
 * All rights reserved.
 * ----------------------------------------------
 *
 * Created at: 11/12/2017
 * Created by: jeroen
 */

import React from 'react';
import PropTypes from 'prop-types'; // ES6
import { graphql } from 'react-apollo';

import CategoriesQuery from '../queries/Categories.graphql';
import { Category } from '../components/Category';

class CategoriesContainer extends React.Component {

    static propTypes = {
        categories: PropTypes.array,
        selectedCategory: PropTypes.object,
        render: PropTypes.func
    };

    constructor(props) {
        super(props);
    }

    categories() {
        if(!this.props.categories) return [];

        return this.props.categories;
    }

    render() {
      return this.categories().map((category) => {
        return this.props.render(category);
      });
    }
}

const CategoriesQueried = graphql(CategoriesQuery, {
  options: (props) => ({
    variables: {
      category: props.selectedCategory ? parseInt(props.selectedCategory.id) : null
    },
  }),
  props: ({ data: { fetchMore, categories }, ownProps }) => ({
    ownProps,
    categories: categories,
    loadCategories(category) {
      return fetchMore({
        variables: {
          category: category ? category : null
        },
        updateQuery: (previousResult, { fetchMoreResult }) => {
          return {
            ...fetchMoreResult,
          };
        },
      });
    },
  }),
});

const CategoriesWithData = CategoriesQueried(CategoriesContainer);
export default CategoriesWithData;
