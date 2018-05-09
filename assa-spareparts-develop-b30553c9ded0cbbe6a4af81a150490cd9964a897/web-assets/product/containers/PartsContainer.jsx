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

import SearchPartQuery from '../queries/SearchPart.graphql';
import { Part } from '../components/Part';
import { AssaAbloyHeader } from '../../header/containers/AssaAbloyHeader';
import Masonry from 'react-masonry-component';
import TagsInput from 'react-tagsinput';
import CategoriesContainer from '../../category/containers/CategoriesContainer';
import { Category } from '../../category/components/Category';
import { Link } from 'react-router-dom';
import Flexbox from 'flexbox-react';


class PartsContainer extends React.Component {

    static propTypes = {
        parts: PropTypes.array,
    };

    constructor(props) {
        super(props);

        this.state = {
            terms: [],
            selectedCategories: []
        };
        this.onSearchChange = this.onSearchChange.bind(this);
        this.onSelectCategory = this.onSelectCategory.bind(this);
        this.revertLastCategory = this.revertLastCategory.bind(this);
    }

    componentDidMount() {
      this.props.search(this.state.terms.join(' '));
    }

    onSearchChange(terms) {
        this.setState({
           terms: terms
        });
        this.props.search(terms.join(' '));
    }

    onSelectCategory(category) {
        this.setState({
          selectedCategories: [
            ...this.state.selectedCategories,
            category
          ]
        });
        this.onSearchChange([
            ...this.state.terms,
            category.name
        ]);
    }

    revertLastCategory() {
        const categories = [
          ...this.state.selectedCategories
        ];
        const poppedCategory = categories.pop();


        this.setState({
            selectedCategories: categories
        });

        const poppedCategoryIndex = this.state.terms.indexOf(poppedCategory.name);

        if(poppedCategoryIndex != -1) {
            const newTerms = [
              ...this.state.terms
            ];
            newTerms.splice(poppedCategoryIndex, 1);

            this.onSearchChange(newTerms);
        }
    }


    parts() {
        if(!this.props.parts) return null;

        return this.props.parts.map((part) => {
          return <Link key={part.id} to={ `/${part.id}` }><Part part={part}></Part></Link>;
        });
    }

    render() {
        const {
            terms,
            selectedCategories
        } = this.state;

        const selectedCategory = selectedCategories.slice(-1)[0];

        var masonryOptions = {
            horizontalOrder: true,
            isFitWidth: true,
            gutter: 10
        };

        return <div>
            <AssaAbloyHeader />
            <TagsInput inputProps={{placeholder: 'Add keyword ...'}} value={terms} onChange={this.onSearchChange} />

            <div className={'content'}>
                <div className={'categories'}>
                    {
                      typeof selectedCategory !== "undefined" &&
                        <a onClick={() => { this.revertLastCategory() }} style={{cursor: 'pointer'}}>
                            <div className={'category'} style={{padding: 10, backgroundColor: 'white', borderColor: '#0096ca', borderWidth: 1, borderStyle: "solid"}}>
                                Go Back
                            </div>
                        </a>
                    }
                    <CategoriesContainer selectedCategory={selectedCategory} render={
                      (category) => <Category key={category.id} category={category} onClick={() => { this.onSelectCategory(category) }}></Category>
                    }/>
                </div>
                <div className={'parts-wrapper'}>
                    <Masonry className={'parts'} options={masonryOptions}>
                      { this.parts() }
                    </Masonry>
                </div>
            </div>

        </div>;
    }
}

const SearchPartQueried = graphql(SearchPartQuery, {
    options: {
        variables: {
            terms: null
        }
    },
    props: ({ data: { fetchMore, parts }, ownProps }) => ({
        ownProps,
        parts: parts,
        search(terms) {
            return fetchMore({
                variables: {
                    terms: terms ? terms : null
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

const SearchPartWithData = SearchPartQueried(PartsContainer);
export default SearchPartWithData;
