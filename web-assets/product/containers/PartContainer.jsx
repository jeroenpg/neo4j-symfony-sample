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

import SinglePartQuery from '../queries/SinglePart.graphql';
import { DetailPart } from '../components/DetailPart';
import { AssaAbloyHeader} from '../../header/containers/AssaAbloyHeader';

class PartContainer extends React.Component {

    static propTypes = {
        part: PropTypes.object,
        partId: PropTypes.number
    };

    constructor(props) {
        super(props);
    }

    render() {
        const { part, back } = this.props;
        return <div>
            <AssaAbloyHeader back={back} />
            <DetailPart part={part} />
        </div>
    }
}

const SinglePartQueried = graphql(SinglePartQuery, {
    options: (props) => ({
        variables: {
            part_id: props.partId
        },
    }),
    props: ({ data: { fetchMore, part }, ownProps }) => ({
        ownProps,
        part: part
    }),
});

const SinglePartWithData = SinglePartQueried(PartContainer);
export default SinglePartWithData;
