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

export class Category extends React.Component {

    static propTypes = {
      onClick: PropTypes.func,
    };

    render() {
        const { id, name, image } = this.props.category;
        const imageSrc = image ? require('../../image/category/' + image) : require('../../image/no_category.png');
        return <a onClick={this.props.onClick} style={{cursor: 'pointer'}}>
            <div className={'category'} style={{padding: 10, borderColor: '#0096ca', borderWidth: 1, borderStyle: "solid"}} {...this.props}>
                <div style={{ textAlign: "center" }}>
                    <img style={{ width: "50%" }} src={imageSrc} />
                    <div>{ name }</div>
                </div>
            </div>
        </a>
    }
}
